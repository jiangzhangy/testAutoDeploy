<div class="flex ">
    <div class="h-screen w-0 md:w-72 flex flex-col">
        <div class="bg-slate-900 h-16 flex justify-center items-center">
            <img class="h-11" src="{{ asset('images/logo.png') }}" alt="AOMEI"><span class="text-white text-xl ml-2">AOMEI ACCOUNT</span>
        </div>
        <div class="flex-1 bg-auth-bg h-screen w-full text-white flex justify-left">
            <ul class="w-full">
                <li tabindex="1" class="py-2 pl-10 hover:bg-slate-400 cursor-pointer active:bg-slate-500 focus:bg-slate-500 focus:border-l-2 focus:border-blue-600"><img class="h-7 inline mr-2" src="{{ asset('images/dashboard/setting.png') }}" alt="个人中心">个人中心</li>
                <li tabindex="2" class="py-2 pl-10 hover:bg-slate-400 cursor-pointer active:bg-slate-500 focus:bg-slate-500 focus:border-l-2 focus:border-blue-600"><img class="h-7 inline mr-2" src="{{ asset('images/dashboard/products.png') }}" alt="我的产品">我的产品</li>
                <li tabindex="3" class="py-2 pl-10 hover:bg-slate-400 cursor-pointer active:bg-slate-500 focus:bg-slate-500 focus:border-l-2 focus:border-blue-600"><img class="h-7 inline mr-2" src="{{ asset('images/dashboard/help.png') }}" alt="我的产品">帮助中心</li>
            </ul>
        </div>
    </div>
    <div class="flex-1 h-screen bg-white flex flex-col">
        <div class="bg-slate-200 h-16 flex justify-between items-center">
            <p class="ml-10">个人中心</p>
            <div class="mr-5 cursor-pointer relative">
                <img class="h-7 inline mr-2" src="{{ asset('images/dashboard/personal.png') }}" alt="账户"><span>66666</span>
                <img class="h-5 inline mr-2" src="{{ asset('images/dashboard/down.png') }}" alt="down">
                <div class="absolute bg-slate-200 pt-2 flex flex-col w-full justify-center items-center hidden">
                    <a href="#" class="flex-1 my-0.5">退出登录</a>
                    <a href="#" class="flex-1 my-0.5">退出登录</a>
                    <a href="#" class="flex-1 my-0.5">退出登录</a>
                </div>
            </div>
        </div>
        <div class="bg-white flex-1"></div>
    </div>
</div>
