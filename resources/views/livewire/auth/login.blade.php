<div style="background-image: url({{ asset('images/backend/bg_Log_in.jpg') }})" class="h-screen flex flex-col items-center pt-20" x-data="{
    isMobile:false,
    inputMobileBorderColor: 'border-[#9FA0A4]',
    inputCodeBorderColor: 'border-[#9FA0A4]',
    mobileErrorShow: 'hidden',
    changeLoginMethod(){
        this.isMobile = !this.isMobile
    },
    mobile:'',
    code:'',
    canClick: true,
    bg_color: 'border-[#3481F6] cursor-pointer',
    text: '发送验证码',
    timer: 60,
    errorText: '',
    showError: false,
    errorClass: 'hidden',
    sendEmailClass: '',
    loading: '',
    loginButtonText: '登录/注册',
    loginButtonClass: 'bg-[#3481F6]',
    validateCodeError: '',
    validateMobileError:'',
    // 绑定手机
    bindPhone(){
        this.loading = 'loader align-middle -mt-1';
        $wire.bindPhone(this.mobile, this.code).then(result => {
                this.loading = '';
                if (result !== null){
                   let resultObj = JSON.parse(result);
                   if (resultObj.code){
                        this.inputCodeBorderColor = 'border-[#FF222D]';
                        this.validateCodeError = resultObj.code[0]
                    }
                    if (resultObj.mobile){
                        this.inputMobileBorderColor = 'border-[#FF222D]';
                        this.validateMobileError = resultObj.mobile[0]
                    }
                }
            });
    },
    // 登录
    login(){

        this.loginButtonText = '登录中...'
        this.loginButtonClass = 'bg-[#9FA0A4]'
        //this.loading = 'loader align-middle -mt-1';
        $wire.submit(this.mobile, this.code).then(result => {
                this.loading = '';
                if (result !== null){
                   let resultObj = JSON.parse(result);
                   if (resultObj){
                    this.loginButtonText = '登录/注册'
                    this.loginButtonClass = 'bg-[#3481F6]'
                    if (resultObj.code){
                        this.inputCodeBorderColor = 'border-[#FF222D]';
                        this.validateCodeError = resultObj.code[0]
                    }
                    if (resultObj.mobile){
                        this.inputMobileBorderColor = 'border-[#FF222D]';
                        this.validateMobileError = resultObj.mobile[0]
                    }
                   }
                }
            });
    },
    // 发送验证码
    countDown(){
        if (!(/^1\d{10}$/.test(this.mobile))){
            this.inputMobileBorderColor = 'border-[#FF222D]';
            this.validateMobileError = '手机号格式错误'
            return;
        }
        if (this.mobileErrorShow === 'hidden' && this.canClick){
            const that = this;
            // 倒计时
            that.positionTimer = setInterval(function (){
                    that.timer--;
                    if (that.timer < 0){
                        that.canClickSendEmailButton(that, true)
                    }else{
                        that.canClickSendEmailButton(that, false)
                    }
                },1000);
                // 发送验证码，如果有错误显示错误并恢复可点击
            $wire.sendCode(this.mobile).then(result => {
                if (result !== null){
                   let resultObj = JSON.parse(result);
                   that.errorText = resultObj.mobile[0];
                   this.showError = true;
                   this.errorClass = '';
                   that.canClickSendEmailButton(that, true)
                   return false;
                }
            });
        }else{
            return
        }
    },
    // 恢复/禁止 发送邮箱按钮
    canClickSendEmailButton(that, canClick = false){
        if (canClick){
            clearInterval(that.positionTimer);
            that.text = '发送验证码';
            that.bg_color = 'text-[#3481F6] border-[#3481F6]';
            that.canClick = true;
            that.timer = 60;
            that.sendEmailClass = '';
        }else{
            that.bg_color = 'text-[#ACAFB5] border-[#ACAFB5] cursor-no-drop';
            that.sendEmailClass = 'cursor-not-allowed';
            that.text = that.timer + 's 重新发送';
            that.canClick = false;
        }
    },
    // 获取登录二维码
    getQRCodeString(){
        $refs.qrHtml.innerHTML = '<div class=\'w-\[180px\] h-\[180px\] flex justify-center items-center\'><div class=\'qrcLoader\'></div></div>'
        $refs.qrStateText.innerHTML = '正在加载二维码...'
        $wire.getQRCodeString().then(function(result) {
          let resultObj = JSON.parse(result);
          if (resultObj.code === 0){
            $refs.qrHtml.innerHTML = '<img class=\'w-\[180px\] h-\[180px\]\' src=\'' + resultObj.qrcode + '\'>'
            $refs.qrStateText.innerHTML = '请使用微信扫描二维码登录'
          }
          if (resultObj.code === 500){
            $refs.qrHtml.innerHTML = '<div class=\'w-\[180px\] h-\[180px\] flex justify-center items-center\'><img src=\'/images/backend/icon_load_fail.png\'></div>'
            $refs.qrStateText.innerHTML = '加载失败 <sapn class=\'cursor-pointer text-\[#3481F6\]\' @click=\'getQRCodeString()\'>重试</sapn>'
          }
        })
    },
    // 初始调用
    init() {
        // 请求登录二维码
        if(@js($linkedAccount) === false){
            this.getQRCodeString()
            this.loginState = setInterval(function (){
                    $wire.checkSubscribe().then(function(res){
                    })
                },2000);
        }

        $watch('isMobile', (isMobile) => {
            if (isMobile){
               clearInterval(this.loginState)
            }else{
                this.loginState = setInterval(function (){
                    $wire.checkSubscribe()
                },2000);
            }
        })
        $watch('mobile', (mobile) => {
                   this.inputMobileBorderColor = 'border-[#9FA0A4]';
                   this.validateMobileError = ''
                })
        $watch('code', (code) => {
           this.inputCodeBorderColor = 'border-[#9FA0A4]';
           this.validateCodeError = ''
        })
    }
}">
    <div class="text-white"><img class="inline" src="{{ asset('images/backend/icon_logo_70.png') }}" alt="AOMEI ACCOUNT"><span class="ml-3 text-3.5xl font-bold align-middle mt-1">AOMEI ACCOUNT</span></div>
    <div class="mt-10 bg-white rounded-md w-125 pt-9">
        {{-- 手机验证码登录 --}}
        @if($linkedAccount === false)
            <template x-if="isMobile">
                <div class="m-10 m-auto text-center" >
                    <h2 class="text-center text-[28px]">手机号登录</h2>
                    @error('systemError')<p class="text-red-500 text-xs mt-1">{{ $message  }}</p>@enderror
                    <input type="tel" class="block m-auto w-[380px] h-[40px] mt-[50px] border rounded pl-1" :class="inputMobileBorderColor" onkeyup="this.value=this.value.replace(/\D/g,'')" x-model="mobile" maxlength="11" placeholder="请输入手机号">
                    <p class="text-[#FF222D] text-sm mt-1 w-[380px] text-left m-auto" x-text="validateMobileError"></p>
                    <p class="text-[#FF222D] text-sm mt-1 w-[380px] text-left m-auto" :class="errorClass" x-text="errorText"></p>
                    <input type="text" class="w-[240px] h-[40px] mt-[20px] border rounded pl-1" :class="inputCodeBorderColor" onkeyup="this.value=this.value.replace(/\D/g,'')" maxlength="6" placeholder="请输入验证码" x-model="code">
                    <button class="h-[40px] ml-2 w-[130px] rounded px-2 border text-[#3481F6]" :class="bg_color" x-text="text" @click="countDown()"></button>
                    <p class="text-[#FF222D] text-sm mt-1 w-[380px] text-left m-auto" x-text="validateCodeError"></p>
                    <button type="button" class="block m-auto mt-[38px] h-[40px] w-[380px] rounded px-2 text-white" :class="loginButtonClass" x-text="loginButtonText" @click="login()"></button>
                    <div><p class="m-auto text-[#64666B] text-sm mt-3">登录或注册成功，即代表您同意傲梅<a class="text-[#338AF5]" href="">服务条款</a>和<a class="text-[#338AF5]" href="">隐私策略</a></p></div>
                    <div class="text-center text-gray-500 todo-striping mt-6">或</div>
                    <button @click="changeLoginMethod()" type="button" class="block bg-white mt-6 h-[40px] w-[200px] mx-auto mb-10 text-center text-xs text-[#3481F6] border border-[#3481F6] rounded-md px-2"><img class="w-5 inline mr-1" src="{{ asset('images/backend/icon_bt_wechat_normal.png') }}" alt="微信图标">使用微信登录</button>

                </div>
            </template>
            {{--微信扫码登录--}}
            <div class="m-10 m-auto text-center" x-show="!isMobile" wire:ignore>
                <div class="flex flex-col justify-center items-center">
                    {{--<iframe class="h-100 m-auto" sandbox="allow-scripts allow-top-navigation allow-same-origin" src="{{ $url }}"></iframe>--}}
                    <h1 class="text-[28px]">微信登录</h1>

                    <div class="border border-[#C7D5E0] my-6" x-ref="qrHtml">
                        <div class="w-[180px] h-[180px] flex justify-center items-center">
                            <div class="qrcLoader"></div>
                        </div>
                    </div>
                    <p class="text-sm text-[#202123]" x-ref="qrStateText">正在加载二维码...</p>
                </div>
                <div class="text-center text-gray-500 todo-striping">或</div>
                <button @click="changeLoginMethod()" type="button" class="block bg-white mt-6 h-9 w-72 mx-auto mb-10 text-center text-sm text-[#3481F6] border border-[#3481F6] rounded-md px-2"><img class="w-5 inline mr-1 mb-0.5" src="{{ asset('images/backend/icon_bt_phone_normal.png') }}" alt="微信图标">使用手机号登录</button>
            </div>
            @else
            {{-- 绑定手机号 --}}
            <div class="m-10 m-auto text-center" >
                <h2 class="text-center text-[28px]">绑定手机号</h2>
                @error('systemError')<p class="text-red-500 text-xs mt-1">{{ $message  }}</p>@enderror
                <input type="tel" class="block m-auto w-[380px] h-[40px] mt-[50px] border rounded pl-1" :class="inputMobileBorderColor" onkeyup="this.value=this.value.replace(/\D/g,'')" x-model="mobile" maxlength="11" placeholder="请输入手机号">
                <p class="text-[#FF222D] text-sm mt-1 w-[380px] text-left m-auto" x-text="validateMobileError"></p>
                @error('reusePhone')<p class="text-[#FF222D] text-sm mt-1 w-[380px] text-left m-auto">{{ $message  }}</p>@enderror
                {{--<p class="text-[#FF222D] text-sm mt-1 w-[380px] text-left m-auto" :class="mobileErrorShow">手机号格式错误</p>--}}
                <p class="text-[#FF222D] text-sm mt-1 w-[380px] text-left m-auto" :class="errorClass" x-text="errorText"></p>
                <input type="text" class="w-[240px] h-[40px] mt-[20px] border rounded pl-1" :class="inputCodeBorderColor" onkeyup="this.value=this.value.replace(/\D/g,'')" maxlength="6" placeholder="请输入验证码" x-model="code">
                <button class="h-[40px] ml-2 w-[130px] rounded px-2 mt-[20px] border text-[#3481F6]" :class="bg_color" x-text="text" @click="countDown()"></button>
                <p class="text-[#FF222D] text-sm mt-1 w-[380px] text-left m-auto" x-text="validateCodeError"></p>
                @error('bound')<p class="text-[#FF222D] text-sm mt-1 w-[380px] text-left m-auto">{{ $message  }}</p>@enderror
                <button type="button" class="block m-auto bg-[#3481F6] mt-[38px] h-[40px] w-[380px] rounded px-2 text-white" @click="bindPhone()">
                    <span :class="loading"></span>
                    绑定
                </button>
                <div><p class="m-auto text-[#64666B] text-sm mt-3 mb-[60px]">绑定或注册成功，即代表您同意傲梅<a class="text-[#338AF5]" href="">服务条款</a>和<a class="text-[#338AF5]" href="">隐私策略</a></p></div>
            </div>
        @endif

    </div>

</div>