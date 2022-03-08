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
            <input class="w-[380px] h-[34px] border border-[#9FA0A4] mt-5 pl-[10px]" type="text" placeholder="请输入昵称">
            <div class="flex justify-end">
                <button @click="$refs.layer.style.display = 'none'" class="w-[120px] h-[34px] mt-[30px] mr-[10px] text-[#64666B] border border-[#ACAFB5] rounded text-sm">取消</button>
                <button class="w-[120px] h-[34px] mt-[30px] bg-[#3481F6] text-white text-white border border-[#ACAFB5] rounded text-sm">确定</button>
            </div>
        </div>
    </div>
</div>