@extends('user.layouts.master')

@section('content')
    <!-- Single Product Start -->
    <div class="container-fluid py-5 mt-5 hero-header">
        <div class="container py-5">
            <div class="row g-4 mb-5">
                <div class="col-lg-8 col-xl-9">
                    <a href="{{ route('userHome') }}">Home</a> > Details
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="border rounded">
                                <a href="#">
                                    <img src="{{ asset('product/' . $product->image) }}" class="img-fluid rounded"
                                        alt="Image">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h4 class="fw-bold">{{ $product->name }}</h4>
                            <span class="text-danger mb-3">( {{ $product->available_items }}items left! )</span>
                            <p class="mb-3">Category: {{ $product->categories_name }}</p>
                            <h5 class="fw-bold mb-3">{{ $product->price }} MMK</h5>
                            <div class="d-flex mb-4">
                                <span>
                                    @php $rate = number_format($rating) @endphp
                                    @for ($i = 1; $i <= $rate; $i++)
                                        <i class="fa fa-star text-secondary"></i>
                                    @endfor

                                    @for ($j = $rating + 1; $j <= 5; $j++)
                                        <i class="fa fa-star"></i>
                                    @endfor
                                </span>

                                <span class="ms-4"><i class="fa-solid fa-eye me-2"></i>{{ count($viewCount) }}</span>
                            </div>
                            <p class="mb-4">{{ $product->description }}</p>
                            <form action="{{ route('product#addToCart') }}" method="POST">
                                @csrf
                                <input type="hidden" name="userId" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="productId" value="{{ $product->id }}">
                                <div class="input-group quantity mb-5" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-minus rounded-circle bg-light border">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" name="count"
                                        class="form-control form-control-sm text-center border-0" value="1">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-plus rounded-circle bg-light border">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="submit"
                                    class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary"><i
                                        class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</button>
                                <!-- Rating -->
                                <button type="button"
                                    class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                                        class="fa fa-shopping-bag me-2 text-secondary" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"></i> Rate this product</button>
                            </form>
                            <div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('product#rating') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="productId" value="{{ $product->id }}">
                                            <div class="modal-body">
                                                <div class="rating-css">
                                                    <div class="star-icon">{{ $user_rating }}
                                                        @if ($user_rating == 0)
                                                            <input type="radio" value="1" name="productRating"
                                                                id="rating1" checked>
                                                            <label for="rating1" class="fa fa-star"></label>
                                                            <input type="radio" value="2" name="productRating"
                                                                id="rating2">
                                                            <label for="rating2" class="fa fa-star"></label>
                                                            <input type="radio" value="3" name="productRating"
                                                                id="rating3">
                                                            <label for="rating3" class="fa fa-star"></label>
                                                            <input type="radio" value="4" name="productRating"
                                                                id="rating4">
                                                            <label for="rating4" class="fa fa-star"></label>
                                                            <input type="radio" value="5" name="productRating"
                                                                id="rating5">
                                                            <label for="rating5" class="fa fa-star"></label>
                                                        @else
                                                            @php $userRating = number_format($user_rating) @endphp
                                                            @for ($i = 1; $i <= $userRating; $i++)
                                                                <input type="radio" value="{{ $i }}"
                                                                    name="productRating" id="rating{{ $i }}"
                                                                    checked>
                                                                <label for="rating{{ $i }}"
                                                                    class="fa fa-star"></label>
                                                            @endfor

                                                            @for ($j = $userRating + 1; $j <= 5; $j++)
                                                                <input type="radio" value="{{ $j }}"
                                                                    name="productRating" id="rating{{ $j }}">
                                                                <label for="rating{{ $j }}"
                                                                    class="fa fa-star"></label>
                                                            @endfor
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Rating</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <nav>
                                <div class="nav nav-tabs mb-3">
                                    <button class="nav-link active border-white border-bottom-0" type="button"
                                        role="tab" id="nav-about-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-about" aria-controls="nav-about"
                                        aria-selected="true">Description</button>
                                    <button class="nav-link border-white border-bottom-0" type="button" role="tab"
                                        id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission"
                                        aria-controls="nav-mission" aria-selected="false">Customer Comment
                                        <span
                                            class="btn btn-sm btn-secondary rounded shadow-sm">{{ count($comments) }}</span>
                                    </button>
                                </div>
                            </nav>
                            <div class="tab-content mb-5">
                                <div class="tab-pane active" id="nav-about" role="tabpanel"
                                    aria-labelledby="nav-about-tab">
                                    <p>{{ $product->description }}</p>
                                </div>
                                <div class="tab-pane" id="nav-mission" role="tabpanel"
                                    aria-labelledby="nav-mission-tab">
                                    @foreach ($comments as $items)
                                        <div class="d-flex">
                                            <img src="{{ asset($items->user_profile != null ? 'profile/' . $items->user_profile : 'admin/img/undraw_profile.svg') }}"
                                                class="img-fluid rounded-circle p-3" style="width: 100px; height: 100px;"
                                                alt="">
                                            <div class="">
                                                <p class="" style="font-size: 14px;">
                                                    {{ $items->created_at->format('j-F-Y') }}</p>
                                                <div class="d-flex justify-content-between">
                                                    <h5>{{ $items->user_name }}</h5>
                                                    @if ($items->user_id == Auth::user()->id)
                                                    <a href="{{route('product#deleteComment', $items->id)}}"><i class="ms-3 text-danger fs-5 fa-solid fa-trash"></i></a>
                                                    @endif
                                                </div>
                                                <p>{{ $items->message }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="tab-pane" id="nav-vision" role="tabpanel">
                                    <p class="text-dark">Tempor erat elitr rebum at clita. Diam dolor diam ipsum et tempor
                                        sit. Aliqu diam
                                        amet diam et eos labore. 3</p>
                                    <p class="mb-0">Diam dolor diam ipsum et tempor sit. Aliqu diam amet diam et eos
                                        labore.
                                        Clita erat ipsum et lorem et sit</p>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('product#comment') }}" method="POST">
                            @csrf
                            <input type="hidden" name="productId" value="{{ $product->id }}">
                            <h4 class="mb-5 fw-bold">Leave a comment</h4>
                            <div class="row g-1">
                                <div class="col-lg-12">
                                    <div class="border-bottom rounded">
                                        <textarea name="comment" id="" class="form-control border-0" cols="30" rows="8"
                                            placeholder="Your Review *" spellcheck="false"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-between py-3 mb-5">
                                        <input type="submit" value="Post Comment"
                                            class="btn border border-secondary text-primary rounded-pill px-4 py-3">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @if (count($productList) != 0)
                <h1 class="fw-bold mb-0">Related products</h1>
            @endif
            <div class="vesitable">
                <div class="owl-carousel vegetable-carousel justify-content-center">
                    @foreach ($productList as $items)
                        @if ($product->id != $items->id)
                            <div class="border border-primary rounded position-relative vesitable-item">
                                <div class="vesitable-img">
                                    <img src="{{ asset('product/' . $items->image) }}"
                                        class="img-fluid w-100 rounded-top" alt="">
                                </div>
                                <div class="text-white bg-primary px-3 py-1 rounded position-absolute"
                                    style="top: 10px; right: 10px;">{{ $items->categories_name }}</div>
                                <div class="p-4 pb-0 rounded-bottom">
                                    <h4>{{ $items->name }}</h4>
                                    <p>{{ Str::words($items->description, 20, '...') }}</p>
                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                        <p class="text-dark fs-5 fw-bold">{{ $items->price }} / kg</p>
                                        <a href="#"
                                            class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i
                                                class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Single Product End -->


    {{-- <!-- Footer Start -->
    <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
        <div class="container py-5">
            <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5) ;">
                <div class="row g-4">
                    <div class="col-lg-3">
                        <a href="#">
                            <h1 class="text-primary mb-0">Fruitables</h1>
                            <p class="text-secondary mb-0">Fresh products</p>
                        </a>
                    </div>
                    <div class="col-lg-6">
                        <div class="position-relative mx-auto">
                            <input class="form-control border-0 w-100 py-3 px-4 rounded-pill" type="number"
                                placeholder="Your Email">
                            <button type="submit"
                                class="btn btn-primary border-0 border-secondary py-3 px-4 position-absolute rounded-pill text-white"
                                style="top: 0; right: 0;">Subscribe Now</button>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="d-flex justify-content-end pt-3">
                            <a class="btn  btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i
                                    class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i
                                    class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-secondary btn-md-square rounded-circle" href=""><i
                                    class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-item">
                        <h4 class="text-light mb-3">Why People Like us!</h4>
                        <p class="mb-4">typesetting, remaining essentially unchanged. It was
                            popularised in the 1960s with the like Aldus PageMaker including of Lorem Ipsum.</p>
                        <a href="" class="btn border-secondary py-2 px-4 rounded-pill text-primary">Read More</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex flex-column text-start footer-item">
                        <h4 class="text-light mb-3">Shop Info</h4>
                        <a class="btn-link" href="">About Us</a>
                        <a class="btn-link" href="">Contact Us</a>
                        <a class="btn-link" href="">Privacy Policy</a>
                        <a class="btn-link" href="">Terms & Condition</a>
                        <a class="btn-link" href="">Return Policy</a>
                        <a class="btn-link" href="">FAQs & Help</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex flex-column text-start footer-item">
                        <h4 class="text-light mb-3">Account</h4>
                        <a class="btn-link" href="">My Account</a>
                        <a class="btn-link" href="">Shop details</a>
                        <a class="btn-link" href="">Shopping Cart</a>
                        <a class="btn-link" href="">Wishlist</a>
                        <a class="btn-link" href="">Order History</a>
                        <a class="btn-link" href="">International Orders</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-item">
                        <h4 class="text-light mb-3">Contact</h4>
                        <p>Address: 1429 Netus Rd, NY 48247</p>
                        <p>Email: Example@gmail.com</p>
                        <p>Phone: +0123 4567 8910</p>
                        <p>Payment Accepted</p>
                        <img src="img/payment.png" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Copyright Start -->
    <div class="container-fluid copyright bg-dark py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>Your Site
                            Name</a>, All right reserved.</span>
                </div>
                <div class="col-md-6 my-auto text-center text-md-end text-white">
                    <!--/*** This template is free as long as you keep the below author’s credit link/attribution link/backlink. ***/-->
                    <!--/*** If you'd like to use the template without the below author’s credit link/attribution link/backlink, ***/-->
                    <!--/*** you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". ***/-->
                    Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a> Distributed By <a
                        class="border-bottom" href="https://themewagon.com">ThemeWagon</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End --> --}}



    <!-- Back to Top -->
    <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i
            class="fa fa-arrow-up"></i></a>
@endsection
