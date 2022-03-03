<div class="bg-auth-bg h-screen flex flex-col items-center pt-20" x-data="{
    isMobile:false,
    inputMobileBorderColor: 'border-slate-200',
    mobileErrorShow: 'hidden',
    changeLoginMethod(){
        this.isMobile = !this.isMobile
    },
    mobile:'',
    code:'',
    canClick: true,
    bg_color: 'bg-sky-500 cursor-pointer',
    text: '发送验证码',
    timer: 60,
    errorText: '',
    showError: false,
    errorClass: 'hidden',
    sendEmailClass: '',
    loading: '',
    // 绑定手机
    bindPhone(){
        this.loading = 'loader align-middle -mt-1';
        $wire.bindPhone(this.mobile, this.code).then(result => {
                this.loading = '';
                if (result !== null){
                   let resultObj = JSON.parse(result);
                }
            });
    },
    // 登录
    login(){
        this.loading = 'loader align-middle -mt-1';
        $wire.submit(this.mobile, this.code).then(result => {
                this.loading = '';
                if (result !== null){
                   let resultObj = JSON.parse(result);
                }
            });
    },
    // 发送验证码
    countDown(){
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
            that.bg_color = 'bg-sky-500';
            that.canClick = true;
            that.timer = 60;
            that.sendEmailClass = '';
        }else{
            that.bg_color = 'bg-slate-300 cursor-no-drop';
            that.sendEmailClass = 'cursor-not-allowed';
            that.text = '重新发送(' + that.timer + ')';
            that.canClick = false;
        }
    },
    // 初始调用
    init() {
        $watch('mobile', (mobile) => {
            if (!(/^1(3|4|5|6|7|8|9)\d{9}$/.test(mobile))){
               this.errorClass = 'hidden';
               this.mobileErrorShow = ''
               this.inputMobileBorderColor = 'border-red-500';
            }else{
               this.mobileErrorShow = 'hidden'
               this.inputMobileBorderColor = '';
            }
        })
    }
}">
    <div class="text-white"><img class="w-9 inline" src="{{ asset('images/logo.png') }}" alt="AOMEI ACCOUNT"><span class="ml-3">AOMEI ACCOUNT</span></div>
    <div class="mt-10 bg-white">
        {{-- 手机验证码登录 --}}
        @if($linkedAccount === false)
            <template x-if="isMobile">
                <div class="m-10">
                    <h2 class="text-center text-xl font-bold">手机号登录</h2>
                    @error('systemError')<p class="text-red-500 text-xs mt-1">{{ $message  }}</p>@enderror
                    <input type="tel" class="block w-full h-9 mt-10 border rounded-md pl-1" :class="inputMobileBorderColor" x-model="mobile" maxlength="11" placeholder="请输入手机号">
                    <p class="text-red-500 text-xs mt-1" :class="mobileErrorShow">手机号格式错误</p>
                    <p class="text-red-500 text-xs mt-1" :class="errorClass" x-text="errorText"></p>
                    <input type="text" class="w-3/5 h-9 mt-6 border border-slate-200 rounded-md pl-1 @error('code') border-red-500 @enderror" maxlength="6" placeholder="请输入验证码" x-model="code"><button class="h-9 ml-2 w-28 rounded-md px-2 text-white" :class="bg_color" x-text="text" @click="countDown()"></button>
                    @error('code')<p class="text-red-500 text-xs mt-1">{{ $message  }}</p>@enderror
                    <button type="button" class="block bg-sky-500 mt-6 h-9 w-full rounded-full px-2 text-white" @click="login()">
                        <span :class="loading"></span>
                        登录/注册
                    </button>
                    <div><p class="w-64 text-xs mt-3">登录或注册成功，即代表您同意傲梅<a class="text-blue-500" href="">服务条款</a>和<a class="text-blue-500" href="">隐私策略</a></p></div>
                    <div class="text-center text-gray-500 todo-striping">或</div>
                    <button @click="changeLoginMethod()" type="button" class="block bg-white mt-6 h-9 w-full border border-slate-200 rounded-full px-2"><img class="w-5 inline mr-1" src="{{ asset('images/wechat-login-icon.png') }}" alt="微信图标">使用微信登录</button>

                </div>
            </template>
            {{--微信扫码登录--}}
            <div class="m-10" x-show="!isMobile">
                <div>
                    <iframe class="h-100" sandbox="allow-scripts allow-top-navigation allow-same-origin" src="{{ $url }}"></iframe>
                </div>
                <div class="text-center text-gray-500 todo-striping">或</div>
                <button @click="changeLoginMethod()" type="button" class="block bg-white mt-6 h-9 w-full border border-slate-200 rounded-full px-2">使用手机号登录</button>
            </div>
            @else
            {{-- 绑定手机号 --}}
            <div class="m-10">
                <h2 class="text-center text-xl font-bold">绑定手机号</h2>
                @error('systemError')<p class="text-red-500 text-xs mt-1">{{ $message  }}</p>@enderror
                <input type="tel" class="block w-full h-9 mt-10 border rounded-md pl-1" :class="inputMobileBorderColor" x-model="mobile" maxlength="11" placeholder="请输入手机号">
                <p class="text-red-500 text-xs mt-1" :class="mobileErrorShow">手机号格式错误</p>
                <p class="text-red-500 text-xs mt-1" :class="errorClass" x-text="errorText"></p>
                <input type="text" class="w-3/5 h-9 mt-6 border border-slate-200 rounded-md pl-1 @error('code') border-red-500 @enderror" maxlength="6" placeholder="请输入验证码" x-model="code"><button class="h-9 ml-2 w-28 rounded-md px-2 text-white" :class="bg_color" x-text="text" @click="countDown()"></button>
                @error('code')<p class="text-red-500 text-xs mt-1">{{ $message  }}</p>@enderror
                <button type="button" class="block bg-sky-500 mt-6 h-9 w-full rounded-full px-2 text-white" @click="bindPhone()">
                    <span :class="loading"></span>
                    绑定
                </button>
                <div><p class="text-xs mt-3">绑定成功，即代表您同意傲梅<a class="text-blue-500" href="">服务条款</a>和<a class="text-blue-500" href="">隐私策略</a></p></div>
            </div>
        @endif

    </div>

</div>