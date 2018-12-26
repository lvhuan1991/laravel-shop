@extends('home.layouts.master')
@section('content')
    <div id="content">
        <div class="car main">
            <div class="carshop">
                <div class="cartitle">
                    <div class="carcheck">
                        <div class="checkbox">
                            <span :class="{check:true,checkon:allCheckStatus}" @click="allChecked" id="allcheck"></span>
                        </div>
                        全选
                    </div>
                    <div class="carname">商品名称</div>
                    <div class="carmoney">单价</div>
                    <div class="carnum">数量</div>
                    <div class="carcount">小计</div>
                    <div class="carhandle">操作</div>
                </div>
                {{--1.先循环所有商品\前提是下面data里面传入了$carts变量--}}
                <div v-for="(v,k) in carts" class="shopcontent" style="height: auto;overflow: hidden">
                    <div class="shopcheck">
                        <div class="checkbox">
                            <span @click="select(v)" :class="{check:true,checkon:v.checked}"></span>
                            <input type="checkbox" name='checkbox' class="checkhide"/>
                        </div>
                    </div>
                    <div class="shopname">
                        <div class="carimg">
                            <a href=""><img :src="v.pic"/></a>
                        </div>
                        <p>
                            <a :href="'/home/content/'+v.good_id">@{{v.title}}</a>
                            <br>
                            <span>@{{ v.spec }}</span>
                        </p>
                    </div>
                    <div class="shopmoney">@{{ v.price }}元</div>
                    <div class="shopnum">

                        <a href="javascript:;" class="num_l" @click="reduce(v)">-</a>
                        <input type="text" v-model="v.num" @change="genxin(v)"/>
                        <a href="javascript:;" class="num_r" @click="add(v)">+</a>
                    </div>
                    <div class="shopcount">@{{ v.num*v.price }}元</div>
                    <div class="shophandle" @click="del(v,k)"><span>x</span></div>
                </div>


            </div>
            <div class="jiesuan">
                {{--2.合计和共计得需要计算属性方法里面解决--}}
                <div class="jixu"><a href="">继续购物</a></div>
                <div class="gongji">共计<span>@{{ carts.length }}</span>件商品</div>
                <div class="heji">合计<span>¥ @{{ totalPrice }}</span></div>
                <div class="gou">
                    <a href="javascript:;" @click="goSettlement">
                        <input type="submit" value="去结算"/>
                    </a>
                </div>

            </div>
        </div>
        {{--@{{hasChecked}}--}}
    </div>
@endsection
@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset ('org/home')}}/css/index.css"/>
@endpush

@push('js')
    <script src="{{asset ('org/home')}}/js/list.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://cdn.bootcss.com/vue/2.5.21/vue.min.js"></script>
    <script src="https://cdn.bootcss.com/axios/0.19.0-beta.1/axios.min.js"></script>
    <script>
        new Vue({
            el: '#content',
            data: {
                carts:{!! $carts !!},
                {{--carts:{{$carts}}这样写在页面上不会报错就是不会实体化，但是在js里面会报错--}}
                allCheckStatus: false,
                hasChecked: []//记录谁现在是选中状态
            },
            methods: {
                add(v) {
                    v.num++;
                    this.update(v);
                },
                reduce(v) {
                    if(v.num <= 1) return;//不能减成负的
                    v.num--;
                    this.update(v);
                },
                // vue内置更新方法
                update(v) {
                    // https://www.kancloud.cn/yunye/axios/234845
                    // put第一个是请求的路由url
                    axios.put("/home/cart/" + v.id, {
                        num: v.num,
                    })
                        .then(function (response) {
                            console.log(response);//成功回调函数
                        });
                },
                genxin(v) {
                    this.update(v);
                },
                del(v,k) {
                    this.carts.splice(k,1);// 删除
                    axios.delete("/home/cart/" + v.id,{
                        num:v.num,
                    }).then(function (response) {
                        console.log(response);//删除成功回调函数
                    });
                },
                //去结算
                goSettlement(){
                  //判断用户是否有勾选商品
                  if (this.totalPrice == 0){
                      layer.msg('请选择要结算的商品');
                      return;
                  }
                  //跳转到订单页面
                    location.href = "{{route('home.order.index')}}?ids=" + this.hasChecked;
                },

                //全选单机事件
                allChecked() {
                    //首先让自己状态 true和false 进行切换
                    this.allCheckStatus = !this.allCheckStatus;
                    //根据全选状态变化让单选跟着变化
                    this.hasChecked = [];
                    this.carts.forEach((v, k) => {
                        if (this.allCheckStatus) {
                            v.checked = true;
                            this.hasChecked.push(v.id);
                        } else {
                            v.checked = false;
                            this.hasChecked = [];
                        }
                    });
                },
                //单项选择
                select(v) {
                    //将自己状态 true/false 转换
                    v.checked = !v.checked;
                    if (v.checked) {
                        //将当前购物车 id 放到了一个新的数组中
                        this.hasChecked.push(v.id);
                    } else {
                        //检测制定元素在数组中位置indexOf,如果元素在数组检测元素,返回该元素位置,如果找不见制定元素,返回-1
                        var pos = this.hasChecked.indexOf(v.id);
                        // console.log(pos);
                        //如果取消选中,将当前取消购物车 id 冲数组踢出去
                        this.hasChecked.splice(pos, 1);
                    }
                    if (this.hasChecked.length == this.carts.length){
                        this.allCheckStatus = true;
                    } else {
                        this.allCheckStatus = false;
                    }
                }
            },
            // vue内置方法：计算属性
            computed: {
                totalPrice() {
                    let total = 0;
                    this.carts.forEach((v, k) => {
                        if (v.checked) {
                            total += v.price * v.num;
                        }
                    })
                    return total;
                }
            }
        })
    </script>
@endpush
