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
        <div x-show="showBoundWechat">
            <h1 class="mt-9 text-lg font-bold">绑定微信</h1>
            <div class="border border-[#C7D5E0] mx-8 my-4 p-[1px]">
                <img class="w-[195px] h-[186px]" src="{{ $QRUrl }}" alt="qr">
            </div>
            <div class="text-sm text-[#64666B] text-center">微信扫描二维码绑定</div>
            <div class="text-sm text-[#202123] flex flex-col mt-10 mb-5">
                <span><span class="border border-[#FF0006] iconfont icon-check text-[#3481F6] mr-1 mb-4"></span> 绑定微信后，可实时收到公众号消息</span>
                <span class="mt-4"><span class="border border-[#FF0006] iconfont icon-check text-[#3481F6] mr-1"></span> 微信扫码即可登录</span>
            </div>
        </div>
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
                <img class="w-[300px] h-[300px]" x-ref="avatar" src="{{ $userInfo['localheadurl'] ?? asset('images/backend/icon_Defaultavatar_100.png') }}" alt="qr">
            </div>
            <p class="text-[#64666B] text-sm">仅支持 JPG、PNG 格式的图片</p>
            <div class="my-7">
                <form wire:submit.prevent="saveAvatar" class="flex justify-between">
                    <div class="w-[80px] h-[34px] border border-[#ACAFB5] rounded text-sm text-[#64666B] overflow-hidden relative ">
                        <div class="my-1.5 ml-[11px]">选择图片</div>
                        <input accept="image/*" class="absolute top-0 text-lg opacity-0" type="file" @change="changed">
                    </div>
                    @error('photo') <span class="error">{{ $message }}</span> @enderror
                    <div>
                        <button @click="$refs.layer.style.display = 'none'" class="text-sm text-[#64666B] w-[80px] h-[34px] border border-[#ACAFB5] rounded mr-2 cursor-pointer">取消</button>
                        <button type="submit" class="text-sm text-white w-[80px] h-[34px] border border-[#ACAFB5] rounded bg-[#3481F6] cursor-pointer">确定</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>