@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Yönetim Paneli
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
    
    <link href="{{ asset('assets/vendors/fullcalendar/css/fullcalendar.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/pages/calendar_custom.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" media="all" href="{{ asset('assets/vendors/jvectormap/jquery-jvectormap.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/animate/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/only_dashboard.css') }}" />
    
@stop

{{-- Page content --}}
@section('content')

<section class="content-header">
    <h1>{!! \App\Setting::find(1)->meta_baslik !!} Yönetim Paneli</h1>
    <ol class="breadcrumb">
        <li class="active">
            <a href="#">
                <i class="livicon" data-name="home" data-size="16" data-color="#333" data-hovercolor="#333"></i> Yönetim Paneli
            </a>
        </li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 margin_10 animated fadeInLeftBig">
            <!-- Trans label pie charts strats here-->
            <div class="lightbluebg no-radius">
                <div class="panel-body squarebox square_boxs">
                    <div class="col-xs-12 pull-left nopadmar">
                        <div class="row">
                            <div class="square_box col-xs-7 text-right">
                                <span>Ürünler</span>
                                <div class="number" id="products">{{ $products }}</div>
                            </div>
                            <i class="livicon  pull-right" data-name="tags" data-l="true" data-c="#fff" data-hc="#fff" data-s="70"></i>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <small class="stat-label">Bugün</small>
                                <h4 id="products.1">{{ $todayProducts }}</h4>
                            </div>
                            <div class="col-xs-6 text-right">
                                <small class="stat-label">Bu Ay</small>
                                <h4 id="products.2">{{ $monthProducts }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 margin_10 animated fadeInUpBig">
            <!-- Trans label pie charts strats here-->
            <div class="palebluecolorbg no-radius">
                <div class="panel-body squarebox square_boxs">
                    <div class="col-xs-12 pull-left nopadmar">
                        <div class="row">
                            <div class="square_box col-xs-7 pull-left">
                                <span>Kayıtlı Üye</span>
                                <div class="number" id="customers">{{ $customers }}</div>
                            </div>
                            <i class="livicon pull-right" data-name="users" data-l="true" data-c="#fff" data-hc="#fff" data-s="70"></i>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <small class="stat-label">Bugün</small>
                                <h4 id="customers.1">{{ $todayCustomers }}</h4>
                            </div>
                            <div class="col-xs-6 text-right">
                                <small class="stat-label">Bu Ay</small>
                                <h4 id="customers.2">{{ $monthCustomers }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 margin_10 animated fadeInDownBig">
            <!-- Trans label pie charts strats here-->
            <div class="redbg no-radius">
                <div class="panel-body squarebox square_boxs">
                    <div class="col-xs-12 pull-left nopadmar">
                        <div class="row">
                            <div class="square_box col-xs-7 pull-left">
                                <span>Siparişler</span>
                                <div class="number" id="orders">{{ $orders }}</div>
                            </div>
                            <i class="livicon pull-right" data-name="piggybank" data-l="true" data-c="#fff" data-hc="#fff" data-s="70"></i>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <small class="stat-label">Bugün</small>
                                <h4 id="orders.1">{{ $todayOrders }}</h4>
                            </div>
                            <div class="col-xs-6 text-right">
                                <small class="stat-label">Bu Ay</small>
                                <h4 id="orders.2">{{ $monthOrders }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-md-6 margin_10 animated fadeInRightBig">
            <!-- Trans label pie charts strats here-->
            <div class="goldbg no-radius">
                <div class="panel-body squarebox square_boxs">
                    <div class="col-xs-12 pull-left nopadmar">
                        <div class="row">
                            <div class="square_box col-xs-7 pull-left">
                                <span>Kazanç</span>
                                <div class="number" id="visitors">{{ number_format($money,2) }} TL</div>
                            </div>
                            <i class="livicon pull-right" data-name="money" data-l="true" data-c="#fff" data-hc="#fff" data-s="70"></i>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <small class="stat-label">Bugün</small>
                                <h4 id="visitors.1">{{ number_format($todayMoney,2) }} TL</h4>
                            </div>
                            <div class="col-xs-6 text-right">
                                <small class="stat-label">Bu Ay</small>
                                <h4 id="visitors.2">{{ number_format($monthMoney,2) }} TL</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/row-->
    <div class="row">
        <div class="col-md-8 col-sm-6">
            <div class="panel panel-border">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="users" class="table table-bordered table-striped">
                            <tbody>
                            <tr>
                                <td colspan="2">İşlem yapmak için soldaki menüyü kullanabilirsiniz.</td>
                            </tr>
                            <tr>
                                <td width="18%">Genel Ayarlar</td>
                                <td>Sitenin başlık, meta etiketleri, genel iletişim bilgileri gibi genel ayarlarını, kargo bilgilerini, dil ve çeviri ayarlarını yönetebilirsiniz.</td>
                            </tr>
                            <tr>
                                <td width="18%">Ödeme Ayarları</td>
                                <td>Ödeme yöntemleri, Sanal POS işlemleri ve banka hesaplarınızı yönetebilirsiniz.</td>
                            </tr>
                            <tr>
                                <td width="18%">Müşteri Yönetimi</td>
                                <td>Müşterilerinizin bilgilerini ve adres detaylarını yönetebilirsiniz.</td>
                            </tr>
                            <tr>
                                <td width="18%">Kategori Yönetimi</td>
                                <td>Web sitenizde listelenecek olan kategorileri yönetebilirsiniz.</td>
                            </tr>
                            <tr>
                                <td width="18%">Ürün Yönetimi</td>
                                <td>Ürün detaylarınızı, görsellerini ve ürün özelliklerini yönetebilirsiniz.</td>
                            </tr>
                            <tr>
                                <td width="18%">Yorum Yönetimi</td>
                                <td>Müşterilerinizin ürünlere yaptığı yorumları yönetebilirsiniz.</td>
                            </tr>
                            <tr>
                                <td width="18%">Siparişler</td>
                                <td>Müşterilerinizden gelen siparişleri yönetebilirsiniz.</td>
                            </tr>
                            <tr>
                                <td>İndirim Kodları (Kuponları)</td>
                                <td>Özel kampanya ve indirimlerinizi yönetebilirsiniz.</td>
                            </tr>
                            <tr>
                                <td>Moderatörler</td>
                                <td>Panel kullanım hakkına sahip yöneticiler ekleyebilir, mevcut yöneticileri yönetebilir, silebilirsiniz.</td>
                            </tr>
                            <tr>
                                <td>İçerik Yönetimi</td>
                                <td>Hakkımızda, üyelik sözleşmesi, koşullar, yardım menüleri gibi sayfaları yönetebilirsiniz.</td>
                            </tr>
                            <tr>
                                <td>Slayt Yönetimi</td>
                                <td>Anasayfanın en üstünde görünmesini istediğiniz önemli kategori, ürün, menü görsellerini ve linklerini yönetebilirsiniz.</td>
                            </tr>
                            <tr>
                                <td>Sosyal Medya</td>
                                <td>Sosyal medya hesaplarınızın linkerini yönetebilirsiniz.</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="panel panel-border">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="users">
                            <tr>
                                <td>E-Ticaret Sistemi</td>
                                <td>{{ $licence->title }}</td>

                            </tr>
                            <tr>
                                <td>Güncel Sürüm</td>
                                <td>{{ $licence->version }}</td>

                            </tr>
                            <tr>
                                <td>Lisans Kodu</td>
                                <td>{{ $licence->code }}</td>

                            </tr>
                            <tr>
                                <td>Lisans Başlangıç Tarihi</td>
                                <td>{{ $licence->begin_date }}</td>
                            </tr>
                            <tr>
                                <td>Lisans Bitiş Tarihi</td>
                                <td>{{ $licence->end_date }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="panel blue_gradiant_bg ">
                <div class="panel-body nopadmar">
                    <div class="row">
                        <div class="col-sm-6 text-center">
                            <h4 class="small-heading">Tamamlanan Siparişler</h4>
                            <span class="chart cir chart-widget-pie widget-easy-pie-1" data-percent="{{ \App\Library\Common::getPercentOfOrders()  }}"><span class="percent">{{ \App\Library\Common::getPercentOfOrders()  }}</span>
                            </span>
                        </div>
                        <!-- /.col-sm-4 -->
                        <div class="col-sm-6 text-center">
                            <h4 class="small-heading">Alışveriş Yapan Müşteriler</h4>
                            <span class="chart cir chart-widget-pie widget-easy-pie-3" data-percent="{{ \App\Library\Common::getPercentOfCusOrders() }}">
                                <span class="percent">{{ \App\Library\Common::getPercentOfCusOrders() }}</span>
                            </span>
                        </div>
                        <!-- /.col-sm-4 -->
                    </div>

                    <!-- /.row -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- END BEGIN Percentage monitor-->
        </div>
    </div>
</section>
        
@stop

{{-- page level scripts --}}
@section('footer_scripts')

    <!-- EASY PIE CHART JS -->
    <script src="{{ asset('assets/vendors/charts/easypiechart.min.js') }}" ></script>
    <script src="{{ asset('assets/vendors/charts/jquery.easypiechart.min.js') }}" ></script>
    <script src="{{ asset('assets/vendors/charts/jquery.easingpie.js') }}" ></script>

    <!-- Back to Top-->
    <script type="text/javascript" src="{{ asset('assets/vendors/countUp/countUp.js') }}" ></script>

    <script src="{{ asset('assets/vendors/jscharts/Chart.js') }}" ></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"  type="text/javascript"></script>


@stop
