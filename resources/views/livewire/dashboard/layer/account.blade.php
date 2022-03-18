<div class="fixed w-screen h-screen top-0 left-0" x-data="{
    // 变量
    nickName:  @entangle('nickName').defer,
    // 修改昵称
    submit(editType){
        $wire.editName(editType).then(result=>{
            $refs.layer.style.display = 'none'
        })
    }
}">
    <div class="absolute top-0 bg-[#03080F] h-screen w-screen opacity-30"></div>
    <div class="absolute px-10 pt-2 pb-4 z-10 bg-white top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 border rounded-md">
        <img @click="$refs.layer.style.display = 'none'" class="absolute w-[26px] h-[26px] right-[18px] top-[18px] cursor-pointer" src="{{ asset('images/backend/icon_window_close_normal.png') }}" alt="x">
        <div x-show="showEditName">
            <h1 class="mt-9 text-lg font-bold">设置昵称</h1>
            <input class="w-[380px] h-[34px] border border-[#9FA0A4] mt-5 pl-[10px]" type="text" placeholder="请输入昵称" x-model="nickName">
            <div class="mb-[10px] flex justify-end">
                <button @click="$refs.layer.style.display = 'none'" class="w-[120px] h-[34px] mt-[30px] mr-[10px] text-[#64666B] border border-[#ACAFB5] rounded text-sm">取消</button>
                <button class="w-[120px] h-[34px] mt-[30px] bg-[#3481F6] text-white text-white border border-[#ACAFB5] rounded text-sm" @click="submit('editName')">确定</button>
            </div>
        </div>
        @if($userInfo['wxdetails'] === null)
        <div x-show="showBoundWechat">
                <h1 class="mt-9 text-lg font-bold">绑定微信</h1>
                <div class="border border-[#C7D5E0] mx-8 my-4 p-[1px]" x-data="{
                init(){
                    new WxLogin({
                    self_redirect:true,
                    id:'code',
                    appid: 'wxd4ac8a5fc03e9cd4',
                    scope: 'snsapi_login',
                    redirect_uri: 'http://491833ii87.zicp.vip/api/user/weixinconnect',
                    state: 'F2342B820364DD36D546A23EEFB57065274A18D0653F860C45728C0FD4CBC762',
                    style: 'white',
                    //href: 'LmltcG93ZXJCb3ggLnFyY29kZSB7d2lkdGg6IDIwMHB4O30NCi5pbXBvd2VyQm94IC50aXRsZSB7ZGlzcGxheTogbm9uZTt9DQouaW1wb3dlckJveCAuaW5mbyB7d2lkdGg6IDIwMHB4O30NCi5zdGF0dXNfaWNvbiB7ZGlzcGxheTogbm9uZX0NCi5pbXBvd2VyQm94IC5zdGF0dXMge3RleHQtYWxpZ246IGNlbnRlcjt9IA==',
                    href: 'data:text/css;base64,LmltcG93ZXJCb3ggLnFyY29kZSB7d2lkdGg6IDE5NXB4O30NCi5pbXBvd2VyQm94IC50aXRsZSB7ZGlzcGxheTogbm9uZTt9DQouaW1wb3dlckJveCAuaW5mbyB7ZGlzcGxheTogbm9uZTt9DQouc3RhdHVzX2ljb24ge2Rpc3BsYXk6IGJsb2NrfQ0KLmltcG93ZXJCb3ggLnN0YXR1cyB7dGV4dC1hbGlnbjogY2VudGVyO30gDQoub2xkLXRlbXBsYXRle21hcmdpbi1sZWZ0OiAtMTA1cHg7bWFyZ2luLXRvcDogLTE2cHg7fQ=='
                    });
                        }
            }">
                    {{--<img class="w-[195px] h-[186px]" src="{{ $QRUrl }}" alt="qr">--}}
                    <div class="w-[195px] h-[186px]" id="code"></div>
                    {{--<iframe class="w-[195px] h-[186px]" sandbox="allow-scripts allow-top-navigation allow-same-origin" src="{{ $QRUrl }}"></iframe>--}}
                </div>
                <div class="text-sm text-[#64666B] text-center">微信扫描二维码绑定</div>
                <div class="text-sm text-[#202123] flex flex-col mt-10 mb-5">
                    <span><span class="border border-[#FF0006] iconfont icon-check text-[#3481F6] mr-1 mb-4"></span> 绑定微信后，可实时收到公众号消息</span>
                    <span class="mt-4"><span class="border border-[#FF0006] iconfont icon-check text-[#3481F6] mr-1"></span> 微信扫码即可登录</span>
                </div>
            </div>
        @endif
        <div x-show="showEditAvatar" x-data="{
           changed(event){
                reader = new FileReader()
                reader.readAsDataURL(event.target.files[0])
                reader.onload = (e)=>{
                    $refs.avatar.src = e.target.result
                }
           },
        }">
            <h1 class="mt-9 text-lg font-bold">修改头像</h1>
            <div class="border border-white m-5 rounded">
                <img class="w-[300px] h-[300px]" x-ref="avatar" src="{{ $userInfo['localheadurl'] ?? asset('images/backend/icon_Defaultavatar_100.png') }}" alt="qr" wire:ignore>
            </div>
            <p class="text-[#64666B] text-sm">仅支持 JPG、PNG 格式的图片、大小不超过1M</p>
            @error('avatar') <span class="text-[#FF222D] text-sm">{{ $message }}</span> @enderror
            <div class="my-7">
                <form wire:submit.prevent="updateAvatar()" class="flex justify-between">
                    <div class="w-[80px] h-[34px] border border-[#ACAFB5] rounded text-sm text-[#64666B] overflow-hidden relative ">
                        <div class="my-1.5 ml-[11px]">选择图片</div>
                        <input accept="image/*" class="absolute top-0 text-lg opacity-0" type="file" @change="changed" wire:model="avatar">
                    </div>
                    <div>
                        <button @click="$refs.layer.style.display = 'none'" class="text-sm text-[#64666B] w-[80px] h-[34px] border border-[#ACAFB5] rounded mr-2 cursor-pointer">取消</button>
                        <button type="submit" class="text-sm text-white w-[80px] h-[34px] border border-[#ACAFB5] rounded bg-[#3481F6] cursor-pointer">确定</button>
                    </div>
                </form>
            </div>
        </div>
        <div x-show="showEditPhone">
            <h1 class="mt-9 text-lg font-bold">修改手机号</h1>
            <div class="flex flex-col mt-2" x-data="{
                buttonStyle: 'border-[#3481F6] text-[#3481F6] cursor-pointer',
                buttonText: '获取验证码',
                canClick: true,
                newPhone: '',
                oldPhone: '',
                timer: 60,
                newPhoneErrorText: '',
                oldPhoneClass: 'border-[#9FA0A4]',
                newPhoneClass: 'border-[#9FA0A4]',
                showNewPhoneErrorText: false,
                showOldPhoneErrorText: false,
                code:'',
                codeStyle: 'border-[#9FA0A4]',
                showCodeErrorText: false,
                codeErrorText: '',
                sendCode(){
                    console.log(this.newPhone)
                    if (this.canClick){
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
                    $wire.sendCode(this.newPhone).then(result => {
                        if (result !== null){
                           let resultObj = JSON.parse(result);
                           that.newPhoneErrorText = resultObj.mobile[0];
                           this.showNewPhoneErrorText = true;
                           this.newPhoneClass = 'border-[#FF222D]';
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
                        that.buttonText = '获取验证码';
                        that.buttonStyle = 'text-[#3481F6] border-[#3481F6] cursor-pointer';
                        that.canClick = true;
                        that.timer = 60;
                    }else{
                        that.buttonStyle = 'text-[#ACAFB5] border-[#C5C7C6] cursor-not-allowed';
                        that.sendEmailClass = 'cursor-not-allowed';
                        that.buttonText = that.timer + 's 重新发送';
                        that.canClick = false;
                    }
                },
                updatePhone(){
                    $wire.updatePhone(this.oldPhone, this.newPhone, this.code).then(result => {
                        if (result !== null){
                           let resultObj = JSON.parse(result);
                           if(resultObj.status === 404){
                               this.oldPhoneClass = 'border-[#FF222D]'
                               this.showOldPhoneErrorText = true
                           }
                           if(resultObj.status === 13004 || resultObj.status === 406){
                               this.codeStyle = 'border-[#FF222D]'
                               this.showCodeErrorText = true
                               this.codeErrorText = resultObj.msg
                           }
                           if(resultObj.status === 14001 || resultObj.status === 12000 || resultObj.status === 405){
                               this.newPhoneClass = 'border-[#FF222D]'
                               this.showNewPhoneErrorText = true
                               this.newPhoneErrorText = resultObj.msg
                           }

                        }
                    })
                }
            }">
                <input class="w-[380px] h-[34px] border rounded mt-2 px-2 text-sm" :class="oldPhoneClass" type="text" placeholder="请输入原手机号" x-model="oldPhone">
                <p class="text-[#FF222D] text-sm mt-1 w-[380px] text-left m-auto" x-show="showOldPhoneErrorText">原手机号输入错误</p>
                <p class="text-[#64666B] text-xs mt-1 w-[380px] text-left m-auto" x-show="showOldPhoneErrorText">如有任何疑问，请联系我们：aomeitech@163.com。</p>

                <input class="w-[380px] h-[34px] border rounded mt-2 px-2 text-sm" :class="newPhoneClass" type="text" placeholder="请输入新手机号" x-model="newPhone">
                <p class="text-[#FF222D] text-sm mt-1 w-[380px] text-left m-auto" x-text="newPhoneErrorText" x-show="showNewPhoneErrorText"></p>

                <div class="flex mt-2">
                    <input class="w-[250px] h-[34px] border rounded px-2 text-sm" :class="codeStyle" type="text" placeholder="请输入验证码" x-model="code">
                    <button class="w-[120px] h-[34px] border rounded px-2 ml-[10px] text-sm" :class="buttonStyle" x-text="buttonText" @click="sendCode()">获取验证码</button>
                </div>
                <p class="text-[#FF222D] text-sm mt-1 w-[380px] text-left m-auto" x-show="showCodeErrorText" x-text="codeErrorText"></p>
                <div class="flex justify-end my-6">
                    <button @click="$refs.layer.style.display = 'none'" class="text-sm text-[#64666B] w-[120px] h-[34px] border border-[#ACAFB5] rounded mr-2 cursor-pointer">取消</button>
                    <button type="submit" class="text-sm text-white w-[120px] h-[34px] border border-[#ACAFB5] rounded bg-[#3481F6] cursor-pointer" @click="updatePhone()">确定</button>
                </div>
            </div>
        </div>
    </div>
</div>