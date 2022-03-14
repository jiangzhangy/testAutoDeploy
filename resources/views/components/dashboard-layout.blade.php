<x-app>
    <x-slot name="title">
       {{ $title ?? '个人中心' }}
    </x-slot>
    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('css/icons/iconfont.css') }}">
        <style>
            [x-cloak] {
                display: none;
            }
        </style>
    </x-slot>
    <x-slot name="script">
        <script src="{{ asset('js/wechatLogin.js') }}"></script>
    </x-slot>
    <x-slot name="main">
        <div x-data="{
            // 展示
            showLayer: false,
            showEditName: false,
            showBoundWechat: false,
            showEditAvatar: false,
            // 改变展示
            changShowLayer(name){
                $refs.layer.style.display =  'block';
                Object.getOwnPropertyNames(this).forEach((key)=>{
                    if (typeof(this[key]) === 'boolean'){
                        this[key] = false
                    }
                });
                this.showLayer = true;
                this[name] = true;
            }
        }">
            <div class="flex">
                <div class="h-screen w-0 md:w-[230px] flex flex-col">
                    <div class="bg-[#14223B] h-[80px] flex justify-center items-center">
                        <img class="h-[34px]" src="{{ asset('images/backend/icon_logo_40.png') }}" alt="AOMEI"><span class="text-white text-base ml-2 font-bold">AOMEI ACCOUNT</span>
                    </div>
                    <div class="flex-1 bg-[#14223B] h-screen w-full">
                        <ul class="w-full text-white flex flex-col justify-left">
                            <li tabindex="1" onclick="location={{ '\'' . route('dashboard-account') . '\'' }}" class="@if(substr(url()->current(), strripos(url()->current(), '/')+1) === 'account') text-white  bg-[#3481F6] @else text-[#B2BFD6] @endif h-14 pt-4 pl-9 text-sm cursor-pointer hover:bg-[#3481F6] hover:text-white active:bg-[#3481F6] active:text-white  focus:bg-[#3481F6] focus:text-white">
                                <span class="iconfont icon-my h-[18px] mr-[24px]"></span>个人中心
                            </li>
                            <li tabindex="2" onclick="location={{ '\'' . route('dashboard-products') . '\'' }}" class="@if(substr(url()->current(), strripos(url()->current(), '/')+1) === 'products') text-white  bg-[#3481F6] @else text-[#B2BFD6] @endif h-14 pt-4 pl-9 text-sm cursor-pointer hover:bg-[#3481F6] hover:text-white active:bg-[#3481F6] active:text-white  focus:bg-[#3481F6] focus:text-white">
                               <span class="iconfont icon-fenlei h-[18px] mr-[24px]"></span>我的产品
                            </li>
                            <li tabindex="3" onclick="location={{ '\'' . route('dashboard-help') . '\'' }}" class="@if(substr(url()->current(), strripos(url()->current(), '/')+1) === 'help') text-white  bg-[#3481F6] @else text-[#B2BFD6] @endif h-14 pt-4 pl-9 text-sm cursor-pointer hover:bg-[#3481F6] hover:text-white active:bg-[#3481F6] active:text-white  focus:bg-[#3481F6] focus:text-white">
                                <span class="iconfont icon-book-open h-[18px] mr-[24px]"></span>帮助中心
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="flex-1 h-screen bg-white flex flex-col">
                    <div class="h-[80px] border border-b-[#D1D6DF] flex justify-between items-center"  x-data="{
                            showItems: false
                        }">
                        <p class="ml-10 text-xl font-bold">{{ $tab ?? '个人中心' }}</p>
                        <div class="cursor-pointer h-[80px] pt-[25px] px-[20px] relative hover:bg-[#d2e3fc]" @click="showItems = !showItems">
                            <img class="h-[30px] inline mr-2" src="{{ asset('images/backend/icon_Defaultavatar_30.png') }}" alt="账户"><span class="text-sm">{{ session('userInfo')['nickname'] ?? 'aomei20220307' }}</span>
                            <img class="h-1.5 inline mr-2" src="{{ asset('images/backend/icon_arrow_down_normal.png') }}" alt="down">
                            <div class="absolute pt-2 flex flex-col w-full justify-center left-0 bottom-[-66px] border rounded border-[#B2BFD6]  text-[#818b9d]" x-show="showItems" @click.outside="showItems = false">
                                <a href="{{ route('dashboard-account') }}" class="flex-1 my-0.5 hover:bg-[#3481F6]"><span class="iconfont icon-my pl-6 h-[18px] mr-[24px]"></span>个人中心</a>
                                <a href="{{ route('logout')  }}" class="flex-1 my-0.5 hover:bg-[#3481F6]"><span class="iconfont icon-logout pl-6 h-[18px] mr-[24px]"></span>退出登录</a>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white flex-1">
                        {{ $content ?? '' }}
                    </div>
                </div>
            </div>

            {{ $layer ?? '' }}
        </div>
    </x-slot>
</x-app>
