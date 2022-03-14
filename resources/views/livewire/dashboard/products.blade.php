<div class="mt-10" x-data="{
    showModal: false,
    showLoader: false,
    showInfo: false,
    showBound: false,
    showBoundInfo: false,
    showBuy: false,
    data: {},
    // 获取对应产品信息
    getInfo(id){
        this.showModal = true
        this.showLoader = true
        $wire.getProductInfo(id).then(result => {
            this.data = JSON.parse(result)
            this.showLoader = false
            this.showInfo = true
        });
    },
    // 获取对应产品绑定信息
    getBoundInfo(id){
        this.showModal = true
        this.showLoader = true
        $wire.getProductInfo(id).then(result => {
            this.data = JSON.parse(result)
            this.showLoader = false
            this.showBoundInfo = true
        });
    },
    // 购买对应产品
    buy(id){
        this.showModal = true
        this.showBuy = true
        $wire.getProductInfo(id).then(result => {
            this.data = JSON.parse(result)
            this.showLoader = false
            this.showBuy = true
        });
    },
    closeDialog(){
        Object.getOwnPropertyNames(this).forEach((key)=>{
                    if (typeof(this[key]) === 'boolean'){
                        this[key] = false
                    }
                });
    }

}">
    <div class="border border-b-[#D1D6DF] border-x-white border-t-white">
        <p class="text-sm text-[#202123] ml-10">已获 VIP 权限产品</p>
        <div class="pb-10 flex flex-wrap">
            <div class="w-[420px] h-[200px] rounded-md ml-10 mt-5" style="background-image: url({{ asset('images/backend/bg_card_ab.png') }})">
                <div class="px-11 py-9 flex flex-row justify-end ">
                    <img class="w-[60px] h-[60px] mt-3" src="{{ asset('images/backend/icon_product_ab.png') }}" alt="">
                    <div class="px-5 flex flex-col ml-2">
                        <div class="flex flex-row items-center">
                            <h2 class="text-lg text-white font-bold">傲梅轻松备份</h2>
                            <div class="text-white text-xs font-bold bg-no-repeat rounded-[3px] px-2 py-0.5 mx-3" style="background-image: url({{ asset('images/backend/bg_Label_vip.png')}})">vip</div>
                            <div class="text-white text-xs font-bold bg-no-repeat rounded-[3px] px-2 py-0.5 " style="background-image: url({{ asset('images/backend/bg_Label_lifelong.png')}})">终身版</div>
                        </div>
                        <div class="text-sm text-white opacity-60 pt-3">
                            支持系统、磁盘、文件等多种备份方式，同时支持4中文件同步。
                        </div>
                    </div>
                </div>
                <div class="flex justify-around px-1">
                    <button class="w-[120px] h-[34px] bg-[#3481F6] rounded text-sm text-white">立即下载</button>
                    <button class="w-[120px] h-[34px] border border-white rounded opacity-50 text-sm text-white" @click="getBoundInfo(1)">绑定设备信息</button>
                    <button class="w-[120px] h-[34px] border border-white rounded opacity-50 text-sm text-white" @click="getInfo(1)">查看详情</button>
                </div>
            </div>
            <div class="w-[420px] h-[200px] rounded-md ml-10 mt-5" style="background-image: url({{ asset('images/backend/bg_card_ab.png') }})">
                <div class="px-11 py-9 flex flex-row justify-end ">
                    <img class="w-[60px] h-[60px] mt-3" src="{{ asset('images/backend/icon_product_ab.png') }}" alt="">
                    <div class="px-5 flex flex-col ml-2">
                        <div class="flex flex-row items-center">
                            <h2 class="text-lg text-white font-bold">傲梅轻松备份</h2>
                            <div class="text-white text-xs font-bold bg-no-repeat rounded-[3px] px-2 py-0.5 mx-3" style="background-image: url({{ asset('images/backend/bg_Label_vip.png')}})">vip</div>
                            <div class="text-white text-xs font-bold bg-no-repeat rounded-[3px] px-2 py-0.5 " style="background-image: url({{ asset('images/backend/bg_Label_lifelong.png')}})">终身版</div>
                        </div>
                        <div class="text-sm text-white opacity-60 pt-3">
                            支持系统、磁盘、文件等多种备份方式，同时支持4中文件同步。
                        </div>
                    </div>
                </div>
                <div class="flex justify-around px-1">
                    <button class="w-[120px] h-[34px] bg-[#3481F6] rounded text-sm text-white">立即下载</button>
                    <button class="w-[120px] h-[34px] border border-white rounded opacity-50 text-sm text-white">绑定设备信息</button>
                    <button class="w-[120px] h-[34px] border border-white rounded opacity-50 text-sm text-white">查看详情</button>
                </div>
            </div>
            <div class="w-[420px] h-[200px] rounded-md ml-10 mt-5" style="background-image: url({{ asset('images/backend/bg_card_ab.png') }})">
                <div class="px-11 py-9 flex flex-row justify-end ">
                    <img class="w-[60px] h-[60px] mt-3" src="{{ asset('images/backend/icon_product_ab.png') }}" alt="">
                    <div class="px-5 flex flex-col ml-2">
                        <div class="flex flex-row items-center">
                            <h2 class="text-lg text-white font-bold">傲梅轻松备份</h2>
                            <div class="text-white text-xs font-bold bg-no-repeat rounded-[3px] px-2 py-0.5 mx-3" style="background-image: url({{ asset('images/backend/bg_Label_vip.png')}})">vip</div>
                            <div class="text-white text-xs font-bold bg-no-repeat rounded-[3px] px-2 py-0.5 " style="background-image: url({{ asset('images/backend/bg_Label_lifelong.png')}})">终身版</div>
                        </div>
                        <div class="text-sm text-white opacity-60 pt-3">
                            支持系统、磁盘、文件等多种备份方式，同时支持4中文件同步。
                        </div>
                    </div>
                </div>
                <div class="flex justify-around px-1">
                    <button class="w-[120px] h-[34px] bg-[#3481F6] rounded text-sm text-white">立即下载</button>
                    <button class="w-[120px] h-[34px] border border-white rounded opacity-50 text-sm text-white">绑定设备信息</button>
                    <button class="w-[120px] h-[34px] border border-white rounded opacity-50 text-sm text-white">查看详情</button>
                </div>
            </div>
            <div class="w-[420px] h-[200px] rounded-md ml-10 mt-5" style="background-image: url({{ asset('images/backend/bg_card_ab.png') }})">
                <div class="px-11 py-9 flex flex-row justify-end ">
                    <img class="w-[60px] h-[60px] mt-3" src="{{ asset('images/backend/icon_product_ab.png') }}" alt="">
                    <div class="px-5 flex flex-col ml-2">
                        <div class="flex flex-row items-center">
                            <h2 class="text-lg text-white font-bold">傲梅轻松备份</h2>
                            <div class="text-white text-xs font-bold bg-no-repeat rounded-[3px] px-2 py-0.5 mx-3" style="background-image: url({{ asset('images/backend/bg_Label_vip.png')}})">vip</div>
                            <div class="text-white text-xs font-bold bg-no-repeat rounded-[3px] px-2 py-0.5 " style="background-image: url({{ asset('images/backend/bg_Label_lifelong.png')}})">终身版</div>
                        </div>
                        <div class="text-sm text-white opacity-60 pt-3">
                            支持系统、磁盘、文件等多种备份方式，同时支持4中文件同步。
                        </div>
                    </div>
                </div>
                <div class="flex justify-around px-1">
                    <button class="w-[120px] h-[34px] bg-[#3481F6] rounded text-sm text-white">立即下载</button>
                    <button class="w-[120px] h-[34px] border border-white rounded opacity-50 text-sm text-white">绑定设备信息</button>
                    <button class="w-[120px] h-[34px] border border-white rounded opacity-50 text-sm text-white">查看详情</button>
                </div>
            </div>
        </div>
    </div>
    <div class="border border-b-[#D1D6DF] border-x-white border-t-white">
        <p class="text-sm text-[#202123] ml-10">其他</p>
        <div class="pb-10 flex flex-wrap">
            <div class="w-[420px] h-[200px] rounded-md ml-10 mt-5" style="background-image: url({{ asset('images/backend/bg_card_ab.png') }})">
                <div class="px-11 py-9 flex flex-row justify-end ">
                    <img class="w-[60px] h-[60px] mt-3" src="{{ asset('images/backend/icon_product_ab.png') }}" alt="">
                    <div class="px-5 flex flex-col ml-2">
                        <div class="flex flex-row items-center">
                            <h2 class="text-lg text-white font-bold">傲梅轻松备份</h2>
                            <div class="text-white text-xs font-bold bg-no-repeat rounded-[3px] px-2 py-0.5 mx-3" style="background-image: url({{ asset('images/backend/bg_Label_vip.png')}})">vip</div>
                            <div class="text-white text-xs font-bold bg-no-repeat rounded-[3px] px-2 py-0.5 " style="background-image: url({{ asset('images/backend/bg_Label_lifelong.png')}})">终身版</div>
                        </div>
                        <div class="text-sm text-white opacity-60 pt-3">
                            支持系统、磁盘、文件等多种备份方式，同时支持4中文件同步。
                        </div>
                    </div>
                </div>
                <div class="flex justify-around px-1">
                    <button class="w-[120px] h-[34px] bg-[#3481F6] rounded text-sm text-white">立即下载</button>
                    <button class="w-[120px] h-[34px] bg-[#FF8400] rounded text-sm text-white" @click="buy(1)">购买</button>
                </div>
            </div>
            <div class="w-[420px] h-[200px] rounded-md ml-10 mt-5" style="background-image: url({{ asset('images/backend/bg_card_ab.png') }})">
                <div class="px-11 py-9 flex flex-row justify-end ">
                    <img class="w-[60px] h-[60px] mt-3" src="{{ asset('images/backend/icon_product_ab.png') }}" alt="">
                    <div class="px-5 flex flex-col ml-2">
                        <div class="flex flex-row items-center">
                            <h2 class="text-lg text-white font-bold">傲梅轻松备份</h2>
                            <div class="text-white text-xs font-bold bg-no-repeat rounded-[3px] px-2 py-0.5 mx-3" style="background-image: url({{ asset('images/backend/bg_Label_vip.png')}})">vip</div>
                            <div class="text-white text-xs font-bold bg-no-repeat rounded-[3px] px-2 py-0.5 ">终身版</div>
                        </div>
                        <div class="text-sm text-white opacity-60 pt-3">
                            支持系统、磁盘、文件等多种备份方式，同时支持4中文件同步。
                        </div>
                    </div>
                </div>
                <div class="flex justify-around px-1">
                    <button class="w-[120px] h-[34px] bg-[#3481F6] rounded text-sm text-white">立即下载</button>
                    <button class="w-[120px] h-[34px] border border-white rounded opacity-50 text-sm text-white" @click="showModal = true; showBound = true">绑定序列码</button>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-auto" style="background-color: rgba(0,0,0,0.5)" x-show="showModal" :class="{ 'absolute inset-0 z-10 flex items-center justify-center': showModal }">
        <div class="loader" x-show="showLoader"></div>
        <!--Dialog-->
        <div class="bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg py-10 text-left pr-6 pl-10" x-show="showModal && showInfo" @click.away="closeDialog()">

            <!--Title-->
            <div class="flex justify-between items-center pb-3">
                <p class="text-lg font-bold">产品详情</p>
                <div class="cursor-pointer z-50" @click="closeDialog()">
                    <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                    </svg>
                </div>
            </div>

            <!-- content -->
            <div class="mt-[20px] flex items-center">
                <img class="h-[70px] w-[70px]" src="{{ asset('images/backend/icon_product_ab.png') }}" alt="">
                <div class="ml-[20px] flex flex-col">
                    <p class="text-[#3481F6] text-base font-bold" x-text="data.name"></p>
                    <p class="text-[#64666B] mt-1 text-sm" x-text="data.subscribe"></p>
                </div>
            </div>
            <div class="flex flex-col mt-3">
                <div class="flex justify-between py-5 border border-white border-b-[#EDEFF2]">
                    <p class="text-sm font-bold text-black">产品名：</p> <span class="text-sm text-[#64666B]" x-text="data.name">傲梅轻松备份</span>
                </div>
                <div class="flex justify-between py-5 border border-white border-b-[#EDEFF2]">
                    <p class="text-sm font-bold text-black">订单号：</p> <span class="text-sm text-[#64666B]" x-text="data.orderNo"></span>
                </div>
                <div class="flex justify-between py-5 border border-white border-b-[#EDEFF2]">
                    <p class="text-sm font-bold text-black">获取时间：</p> <span class="text-sm text-[#64666B]" x-text="data.orderCreateDate"></span>
                </div>
                <div class="flex justify-between py-5 border border-white border-b-[#EDEFF2]">
                    <p class="text-sm font-bold text-black">订阅方式：</p> <span class="text-sm text-[#64666B]" x-text="data.subscribe"></span>
                </div>
                <div class="flex justify-between py-5 border border-white border-b-[#EDEFF2]">
                    <p class="text-sm font-bold text-black">支持设备数：</p> <span class="text-sm text-[#64666B]" x-text="data.devicesNum"></span>
                </div>
                <div class="flex justify-between py-5 border border-white border-b-[#EDEFF2]">
                    <p class="text-sm font-bold text-black">有效期：</p> <span class="text-sm text-[#64666B]" x-text="data.expiryData"></span>
                </div>
            </div>

            <!--Footer-->
            <div class="flex justify-end pt-2 mt-8">
                {{--<button class="px-4 bg-transparent p-3 rounded-lg text-indigo-500 hover:bg-gray-100 hover:text-indigo-400 mr-2" @click="alert('Additional Action');">Action</button>--}}
                <button class="modal-close px-2 bg-[#3481F6] p-3 rounded-lg text-white hover:bg-indigo-400" @click="closeDialog()">确定</button>
            </div>


        </div>
        <div class="bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg py-10 text-left pr-6 pl-10" x-show="showModal && showBound" @click.away="closeDialog()">

            <!--Title-->
            <div class="flex justify-between items-center pb-3">
                <p class="text-lg font-bold">绑定注册码</p>
                <div class="cursor-pointer z-50 -mt-[62px] -mr-[7px]" @click="closeDialog()">
                    <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                    </svg>
                </div>
            </div>

            <!-- content -->
            <input class="w-[380px] h-[34px] border border-[#9FA0A4] rounded px-2" placeholder="请输入要绑定的注册码" type="text">

            <!--Footer-->
            <div class="flex justify-end pt-2 mt-4">
                <button class="modal-close w-[120px] h-[34px] border border-[#9FA0A4] rounded text-[#64666B]" @click="closeDialog()">取消</button>
                <button class="modal-close w-[120px] h-[34px] bg-[#3481F6] rounded text-white ml-[20px]" @click="bound(id)">确定</button>
            </div>


        </div>
        <div class="bg-white mx-auto rounded shadow-lg py-10 text-left pr-6 pl-10" x-show="showModal && showBoundInfo" @click.away="closeDialog()">

            <!--Title-->
            <div class="flex justify-between items-center pb-3">
                <p class="text-lg font-bold">已绑定设备</p>
                <div class="cursor-pointer z-50" @click="closeDialog()">
                    <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                    </svg>
                </div>
            </div>

            <!-- content -->
            <table >
                <thead class="bg-[#A2A9B0] text-sm text-white">
                    <tr>
                        <th class="p-2.5">ID</th>
                        <th class="p-2.5">设备名</th>
                        <th class="p-2.5">IP</th>
                        <th class="p-2.5">绑定次数</th>
                        <th class="p-2.5">最新绑定时间</th>
                        <th class="p-2.5">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-[#D6E7FF]">
                        <td class="p-2.5">1</td>
                        <td class="p-2.5">EDSKTOP-PC</td>
                        <td class="p-2.5">192.168.2.1</td>
                        <td class="p-2.5">5</td>
                        <td class="p-2.5">2021-10-12 12:45:12</td>
                        <td class="p-2.5">...</td>
                    </tr>
                    <tr class="hover:bg-[#D6E7FF]">
                        <td class="p-2.5">1</td>
                        <td class="p-2.5">EDSKTOP-PC</td>
                        <td class="p-2.5">192.168.2.1</td>
                        <td class="p-2.5">5</td>
                        <td class="p-2.5">2021-10-12 12:45:12</td>
                        <td class="p-2.5">...</td>
                    </tr>

                    <tr class="hover:bg-[#D6E7FF]">
                        <td class="p-2.5">1</td>
                        <td class="p-2.5">EDSKTOP-PC</td>
                        <td class="p-2.5">192.168.2.1</td>
                        <td class="p-2.5">5</td>
                        <td class="p-2.5">2021-10-12 12:45:12</td>
                        <td class="p-2.5">...</td>
                    </tr>

                </tbody>
            </table>

            <!--Footer-->
            <div class="flex justify-end pt-2 mt-8">
                {{--<button class="px-4 bg-transparent p-3 rounded-lg text-indigo-500 hover:bg-gray-100 hover:text-indigo-400 mr-2" @click="alert('Additional Action');">Action</button>--}}
                <button class="modal-close px-2 bg-[#3481F6] p-3 rounded-lg text-white hover:bg-indigo-400" @click="closeDialog()">确定</button>
            </div>


        </div>
        <div class="bg-white mx-auto rounded shadow-lg py-10 text-left pr-6 pl-10" x-show="showModal && showBuy" @click.away="closeDialog()">

            <!--Title-->
            <div class="flex justify-between items-center pb-3">
                <p class="text-lg font-bold">支付购买信息</p>
                <div class="cursor-pointer z-50" @click="closeDialog()">
                    <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                    </svg>
                </div>
            </div>

            <!-- content -->
            <div class="w-[420px] h-[120px] border border-[#D4D6D9] rounded-lg text-sm flex justify-between items-center p-5 ">
                <div class="">
                    <div class="flex flex-row justify-between items-center mb-2">
                        <p>软件名称：</p>
                        <p class="text-[#64666B] ml-4">傲梅轻松备份</p>
                    </div>
                    <div class="flex flex-row justify-between items-center mb-2">
                        <p>版本：</p>
                        <p class="text-[#64666B]">终身版</p>
                    </div>
                    <div class="flex flex-row justify-between items-center mb-2">
                        <p>软件价格：</p>
                        <p class="text-xl text-[#3481F6]">98.00 ￥</p>
                    </div>
                </div>
                <img class="w-[60px] h-[60px] mt-3" src="{{ asset('images/backend/icon_product_ab.png') }}" alt="">
            </div>
            <div class="" x-show="false">
                <div class="text-sm flex flex-col justify-center items-center mt-8 mb-8">
                    <p>扫码支付</p>
                    <img class="w-[140px] mt-6" src="{{ asset('images/buy.png') }}" alt="">
                    <div class="mt-6 flex flex-row text-xs text-[#64666B]">
                        <p class="mr-5"><img class="inline" src="{{ asset('images/backend/icon_pay_WeChat_20.png') }}" alt=""> 微信扫码支付</p>
                        <p><img class="inline" src="{{ asset('images/backend/icon_pay_Alipay_20.png') }}" alt=""> 支付宝扫码支付</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-col justify-center items-center mt-12" x-show="true">
                <img src="{{ asset('images/backend/icon_buy_success.png') }}" alt="">
                <p class="text-[26px] mt-6">购买成功</p>
                <span class="text-sm text-[#64666B] my-6">购买信息请到《个人中心》我的产品<a class="text-[#3481F6]" href=""> 查看 >></a></span>
            </div>
            <hr>
            <div class="mt-6 flex justify-center">
                <p class="text-sm text-[#ACAFB5]">同意并接受<a href="" class="text-[#3481F6]">《傲梅会员服务条款》</a></p>
            </div>
            <!--Footer-->


        </div>
        <!--/Dialog -->
    </div>
</div>
