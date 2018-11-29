var Common = require("../../res/common.js");
var App = getApp();
Page({
  /**
   * 页面的初始数据
   */
  data: {
    'Province': [],
    'City': [],
    'Area': [],
    'A1': 8,
    'A2': 0,
    'A3': 0,
    name: '',
    tel: '',
    addr: '',
    cphm: '',
    sfz1: '',
    sfz2: '',
    CarCodes: App.data['CarCodes'],
    CarIndex: 0,
    price: '',
    modal: false,
    exImg: '',
    showCode:false
  },
  ShowCode: function () {
    this.setData({
      ShowCode: true
    })
  },
  HideCode: function () {
    this.setData({
      ShowCode: false
    })
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    //初始化地区数据
    this.setData({ 'Province': Common.AreaData1, 'City': Common.GetData(2, Common.AreaData1[8].id) });
    this.setData({ 'Area': Common.GetData(3, this.data.City[0].id) });

  },
  SetArea: function (e) {
    console.log(e);
    var i = e.currentTarget.dataset.id;
    var n = e.detail.value; //序号
    if (i == 1) {
      var City = Common.GetData(2, this.data.Province[n].id);
      var Area = Common.GetData(3, City[0].id);
      this.setData({ 'A1': n, 'City': City, 'Area': Area, 'A2': 0, 'A3': 0 })
    } else if (i == 2) {
      var Area = Common.GetData(3, this.data.City[n].id);
      this.setData({ 'Area': Area, 'A2': n, 'A3': 0 })
    } else {
      this.setData({ 'A3': n })
    }
  },
  //填充已选区域
  FullArea: function (a1, a2, a3) {
    var ProIndex = '';//省份下标
    var CityIndex = '';//市区下标
    var AreaIndex = '';//县城下标
    var City = [];
    var Area = [];
    for (var i in (this.data.Province)) {
      if ((this.data.Province)[i].id == a1) {
        ProIndex = i;
      }
    }
    //取出城市
    var Allcitys = Common.GetData(2, a1);
    for (var j in Allcitys) {
      if (Allcitys[j].id == a2) {
        CityIndex = j;
      }
    }
    // 取出区域
    var Area = Common.GetData(3, a2);
    for (var k in Area) {
      if (Area[k].id == a3) {
        AreaIndex = k;
      }
    }
    this.setData({
      City: Allcitys,
      Area: Area,
      A1: ProIndex,
      A2: CityIndex,
      A3: AreaIndex
    })
  },
  //或许已有信息
  GetUserInfo: function () {
    wx.showLoading({
      title: '加载中',
    })
    var that = this;
    wx.request({
      url: App.data['API_URL'] + '?m=Mini&a=UserInfo&type=1&sessionkey=' + wx.getStorageSync('sessionkey'),
      method: "GET",
      header: {
        'content-type': 'application/json'
      },
      success: function (res) {
        wx.hideLoading();
        if (res.data.code == 1) {
          var info = res.data.user;
          if (info != '' && info != null) {
            if (info.a2 != 0||info.a3!=0) {
              that.FullArea(info.a1, info.a2, info.a3);
            }  
            that.setData({
              name: info.name,
              tel: info.tel,
              addr: info.adr,
              cphm: info.cphm.substr(2, 5),
              sfz1: info.sfz1,
              sfz2:info.sfz2,
              headimg: info.cardimg,
              video: info.video,
              CarIndex: info.cpm,
              price: res.data.info.price
            })
          } else {
            that.setData({
              price: res.data.info.price
            })
          }
        }
      }
    })
  },
  SubmitData: function (e) {
    var formid = e.detail.formId;
    var cphm = e.detail.value.cphm;
    var tel = e.detail.value.tel;
    var adr = e.detail.value.adr;
    var name = e.detail.value.name;
    if (cphm.length != 5) {
      Common.ErrTips('请填写五位车牌号码！')
    } else if (tel == '') {
      Common.ErrTips('请填写联系电话！')
    } else if (name == '') {
      Common.ErrTips('请填写车主姓名！')
    } else if (adr == '') {
      Common.ErrTips('请填写详细地址！')
    } else if (this.data.sfz1 == '') {
      Common.ErrTips('请上传您的身份证正面！')
    } else if (this.data.sfz2 == '') {
      Common.ErrTips('请上传您的身份证反面！')
    } else {
      var a1 = this.data.Province[this.data.A1].id;
      var a2 = this.data.City[this.data.A2].id;
      var a3 = this.data.Area[this.data.A3].id;
      var cp = this.data.CarCodes[this.data.CarIndex].id;
      wx.showLoading({
        title: '正在提交',
      })
      wx.request({
        url: App.data['API_URL'] + '?m=Travel&a=MakeOrder&sessionkey=' + wx.getStorageSync('sessionkey'),
        data: { 'formid': formid, "cp": cp, 'cphm': cphm, 'tel': tel, 'adr': adr, 'name': name, 'a1': a1, 'a2': a2, 'a3': a3, "sfz1": this.data.sfz1, "sfz2": this.data.sfz2 },
        method: 'POST',
        fail: function () {
          Common.ErrTips('请求失败！');
          wx.hideLoading();
        },
        success: function (r) {
          console.log(r);
          wx.hideLoading();
          if (r.data.code == 1) {
            // 跳转到支付页
            wx.navigateTo({ url: 'pay?id=' + r.data.id });
          } else {
            Common.ErrTips(r.data.msg)
          }
        }
      })
    }
  },

  //选择车牌
  ChangeCarCode: function (e) {
    this.setData({
      CarIndex: e.detail.value
    })
  },
  //示例图片
  ShowImg: function (e) {
    var src = e.currentTarget.dataset.img;
    console.log(src);
    this.setData({
      exImg: '../../res/' + src + '.jpg',
      modal: true
    })
  },
  //隐藏模态
  HideModal: function () {
    this.setData({
      modal: false
    })
  },
  //选择图片
  ChooseSfz: function (e) {
    var ty = e.currentTarget.dataset.id;
    var that = this;
    wx.chooseImage({
      count: 1, // 默认9
      sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
      sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
      success: function (res) {
        // 返回选定照片的本地文件路径列表，tempFilePath可以作为img标签的src属性显示图片
        var tempFilePaths = res.tempFilePaths;
        that.UploadFile(tempFilePaths, ty);
      }
    })
  },
  //上传图片
  UploadFile: function (arr, style) {
    var that = this;
    var len = arr.length;
    for (var i in arr) {
      wx.uploadFile({
        url: App.data['API_URL'] + '?m=Mini&a=UploadFile&sessionkey=' + wx.getStorageSync('sessionkey'),
        filePath: arr[i],
        name: 'file',
        success: function (res) {
          var data = JSON.parse(res.data);
          if (style == "sfz1") {
            that.setData({
              sfz1:App.data["API_URL"]+data.file
            })
          } else {
            that.setData({
              sfz2:App.data["API_URL"]+data.file
            })
          }

          //do something
        }
      })
    }

  },
  //删除身份证
  DelSfz: function (e) {
    var id = e.currentTarget.dataset.id;
    console.log(id);
    if(id=="sfz1"){
      this.setData({
        sfz1: ''
      })
    }else{
      this.setData({
        sfz2: ''
      })
    }
      
  },
  //预览图片
  PreviewImg: function (res) {
    var id = res.currentTarget.dataset.id;
    if(id=="sfz1"){
      wx.previewImage({
        current: '', // 当前显示图片的http链接
        urls: [this.data.sfz1] // 需要预览的图片http链接列表
      })
    }else{
      wx.previewImage({
        current: '', // 当前显示图片的http链接
        urls:[ this.data.sfz2], // 需要预览的图片http链接列表
      })
    }
    
  },
  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
    this.GetUserInfo();
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
    App.IsLogin();
  },
  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  },
  CallUs: function () {
    wx.makePhoneCall({
      phoneNumber: '037168901001'
    })
  }
})