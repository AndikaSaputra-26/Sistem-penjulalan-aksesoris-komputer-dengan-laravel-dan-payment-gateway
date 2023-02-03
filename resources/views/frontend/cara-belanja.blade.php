@extends('layouts.master-frontend')
@section('title', 'Tentang Kami')
@section('content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="/">Home</a></li>
                    <li class='active'>Cara Belanja</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div><!-- /.container -->
    </div>

    <div class="body-content">
        <div class="container">
            <div class="checkout-box faq-page">
				<div class="row">
					<div class="col-md-6">
						<h2 class="heading-title">Cara Belanja</h2>
						<div class="panel-group checkout-steps" id="accordion">
							<!-- checkout-step-01  -->
							@foreach ($model as $item)
							<div class="panel panel-default checkout-step-01">
								<!-- panel-heading -->
								<div class="panel-heading">
									<h4 class="unicase-checkout-title">
										<a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
											<span>{{ $loop->iteration }}</span>{{ $item->title }}
										</a>
									</h4>
								</div>
								<!-- panel-heading -->

								<div id="collapseOne" class="panel-collapse collapse">

									<!-- panel-body  -->
									<div class="panel-body">
										{{ $item->deskripsi }}
									</div>
									<!-- panel-body  -->

								</div><!-- row -->
							</div>
							@endforeach
						</div><!-- /.checkout-steps -->
					</div>

                    <div class="col-md-6">
                        <center>
                            <img src="{{ asset('temp-front-end/assets/images/how.webp') }}" alt="" width="80%">
                        </center>
					</div>


				</div><!-- /.row -->
			</div><!-- /.checkout-box -->
            <!-- ============================================== BRANDS CAROUSEL ============================================== -->
            <div id="brands-carousel" class="logo-slider wow fadeInUp">



            </div>
        </div>
    @endsection
