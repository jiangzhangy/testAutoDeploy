<div class="fixed w-screen h-screen top-0 left-0" x-data="{
    // 变量
    nickName:  @entangle('nickName').defer,
    // 修改昵称
    submit(editType){
        $wire.editName(editType).then(result=>{
            data = JSON.parse(result)
            if (data.code){
                $refs.nickNameInput.style = 'border-color: rgb(220 38 38);'
                $refs.nickNameError.innerHTML = data.msg
            }
        })
    }
}">
    <div class="absolute top-0 bg-[#03080F] h-screen w-screen opacity-30"></div>
    <div class="absolute px-10 pt-2 pb-4 z-10 bg-white top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 border rounded-md">
        <img @click="$refs.layer.style.display = 'none';showBoundWechat = false" class="absolute w-[26px] h-[26px] right-[18px] top-[18px] cursor-pointer" src="{{ asset('images/backend/icon_window_close_normal.png') }}" alt="x">
        <div x-show="showEditName">
            <h1 class="mt-9 text-lg font-bold">设置昵称</h1>
            <input class="w-[380px] h-[34px] border border-[#9FA0A4] mt-5 pl-[10px]" type="text" placeholder="请输入昵称" x-ref="nickNameInput" x-model="nickName">
            <p class="text-[#FF222D] text-sm mt-1 w-[380px] text-left m-auto" x-ref="nickNameError"></p>
            <div class="mb-[10px] flex justify-end">
                <button @click="$refs.layer.style.display = 'none'" class="w-[120px] h-[34px] mt-[30px] mr-[10px] text-[#64666B] border border-[#ACAFB5] rounded text-sm">取消</button>
                <button class="w-[120px] h-[34px] mt-[30px] bg-[#3481F6] text-white text-white border border-[#ACAFB5] rounded text-sm" @click="submit('editName')">确定</button>
            </div>
        </div>
        @if($userInfo['wxdetails'] === null)
        <div x-show="showBoundWechat" x-data="{
            init(){
                $watch('showBoundWechat', (showBoundWechat) => {
                  if (showBoundWechat){
                    this.loginState = setInterval(function (){
                    $wire.checkSubscribe().then(function(result) {
                      if (result !== null){
                        let resultObj = JSON.parse(result);
                        $refs.boundErrorText.innerHTML = resultObj.msg
                      }
                    })
                    },2000);
                  }else{
                    clearInterval(this.loginState)
                  }
                })
            }
        }">
                <h1 class="mt-9 text-lg font-bold">绑定微信</h1>
                <div class="border border-[#C7D5E0] mx-8 my-4 p-[1px]" x-data="">
                    <img class="w-[195px] h-[186px]" src="{{ $QRUrl }}" alt="qr">
                </div>
                <div class="text-sm text-[#64666B] text-center">微信扫描二维码绑定</div>
                <p class="text-red-500 text-xs mt-1 text-center" x-ref="boundErrorText" wire:ignore></p>
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
                },
                init(){
                    // 重新加载修改框错误重置
                    $watch('showEditPhone', (showEditPhone) => {
                        if (showEditPhone === true){
                            this.oldPhoneClass = 'border-[#9FA0A4]'
                            this.newPhoneClass = 'border-[#9FA0A4]'
                            this.codeStyle = 'border-[#9FA0A4]'
                            this.showOldPhoneErrorText = false
                            this.showNewPhoneErrorText = false
                            this.codeErrorText = false
                            this.oldPhone = ''
                            this.newPhone = ''
                            this.code = ''
                        }
                    })
                }
            }">
                <input class="w-[380px] h-[34px] border rounded mt-2 px-2 text-sm" :class="oldPhoneClass"  onkeyup="this.value=this.value.replace(/\D/g,'')" type="tel" maxlength="11" placeholder="请输入原手机号" x-model="oldPhone">
                <p class="text-[#FF222D] text-sm mt-1 w-[380px] text-left m-auto" x-show="showOldPhoneErrorText">原手机号输入错误</p>
                <p class="text-[#64666B] text-xs mt-1 w-[380px] text-left m-auto" x-show="showOldPhoneErrorText">如有任何疑问，请联系我们：aomeitech@163.com。</p>

                <input class="w-[380px] h-[34px] border rounded mt-2 px-2 text-sm" :class="newPhoneClass" onkeyup="this.value=this.value.replace(/\D/g,'')" type="tel" maxlength="11" placeholder="请输入新手机号" x-model="newPhone">
                <p class="text-[#FF222D] text-sm mt-1 w-[380px] text-left m-auto" x-text="newPhoneErrorText" x-show="showNewPhoneErrorText"></p>

                <div class="flex mt-2">
                    <input class="w-[250px] h-[34px] border rounded px-2 text-sm" :class="codeStyle" onkeyup="this.value=this.value.replace(/\D/g,'')" type="tel" maxlength="6" placeholder="请输入验证码" x-model="code">
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