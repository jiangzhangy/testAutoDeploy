<x-app>
    <x-slot name="title">
        个人中心
    </x-slot>
    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('css/icons/iconfont.css') }}">
    </x-slot>
    <x-slot name="script">
    </x-slot>
    <x-slot name="main">
        <div class="flex">
            <div class="h-screen w-0 md:w-[230px] flex flex-col">
                <div class="bg-[#14223B] h-[80px] flex justify-center items-center">
                    <img class="h-[34px]" src="{{ asset('images/backend/icon_logo_40.png') }}" alt="AOMEI"><span class="text-white text-base ml-2 font-bold">AOMEI ACCOUNT</span>
                </div>
                <div class="flex-1 bg-[#14223B] h-screen w-full">
                    <ul class="w-full text-white flex flex-col justify-left">
                        <li tabindex="1" onclick="location={{ '\'' . route('dashboard-account') . '\'' }}" class="h-14 pt-4 pl-9 text-sm text-[#B2BFD6] cursor-pointer hover:bg-[#3481F6] hover:text-white active:bg-[#3481F6] active:text-white  focus:bg-[#3481F6] focus:text-white">
                            <span class="iconfont icon-my h-[18px] mr-[24px]"></span>个人中心
                        </li>
                        <li tabindex="2" onclick="location={{ '\'' . route('dashboard-products') . '\'' }}" class="h-14 pt-4 pl-9 text-sm text-[#B2BFD6] cursor-pointer hover:bg-[#3481F6] hover:text-white active:bg-[#3481F6] active:text-white  focus:bg-[#3481F6] focus:text-white">
                           <span class="iconfont icon-my h-[18px] mr-[24px]"></span>我的产品
                        </li>
                        <li tabindex="3" onclick="location={{ '\'' . route('dashboard-help') . '\'' }}" class="h-14 pt-4 pl-9 text-sm text-[#B2BFD6] cursor-pointer hover:bg-[#3481F6] hover:text-white active:bg-[#3481F6] active:text-white  focus:bg-[#3481F6] focus:text-white">
                            <span class="iconfont icon-my h-[18px] mr-[24px]"></span>帮助中心
                        </li>
                    </ul>
                </div>
            </div>
            <div class="flex-1 h-screen bg-white flex flex-col">
                <div class="h-[80px] border border-b-[#D1D6DF] flex justify-between items-center">
                    <p class="ml-10 text-xl font-bold">个人中心</p>
                    <div class="mr-5 cursor-pointer relative">
                        <img class="h-[30px] inline mr-2" src="{{ asset('images/backend/icon_Defaultavatar_30.png') }}" alt="账户"><span class="text-sm">{{ session('auth')['nickname'] }}</span>
                        <img class="h-1.5 inline mr-2" src="{{ asset('images/backend/icon_arrow_down_normal.png') }}" alt="down">
                        <div class="absolute bg-slate-200 pt-2 flex flex-col w-full justify-center items-center hidden">
                            <a href="#" class="flex-1 my-0.5">个人中心</a>
                            <a href="#" class="flex-1 my-0.5">退出登录</a>
                        </div>
                    </div>
                </div>
                <div class="bg-white flex-1">
                    {{ $content ?? '' }}
                </div>
            </div>
        </div>

    </x-slot>
</x-app>
