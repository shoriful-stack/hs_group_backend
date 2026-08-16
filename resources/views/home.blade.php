@extends('layouts.app')

@section('content')
 <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-4">
                  <div class="col">
                    <a href="{{ route('brands.index') }}" class="text-black">
                        <div class="card radius-10">
                          <div class="card-body">
                              <div class="d-flex align-items-center">
                                  <div>
                                      <p class="mb-0 text-secondary">Total Brands</p>
                                      <h4 class="my-1">{{ $totalBrand }}</h4>
                                  </div>
                                  <div class="widget-icon-large bg-gradient-success text-white ms-auto"><i class="bi bi-list"></i>
                                  </div>
                              </div>
                          </div>
                      </div>
                    </a>
                  </div>
                                   <div class="col">
                    <a href="{{ route('projects.index') }}" class="text-black">
                        <div class="card radius-10">
                          <div class="card-body">
                              <div class="d-flex align-items-center">
                                  <div>
                                      <p class="mb-0 text-secondary">Total Projects</p>
                                      <h4 class="my-1">{{ $totalProject }}</h4>
                                    
                                  </div>
                                  <div class="widget-icon-large bg-gradient-purple text-white ms-auto"><i class="bi bi-person"></i>
                                  </div>
                              </div>
                          </div>
                      </div>
                    </a>
                  </div>
                  <div class="col">
                    <a href="{{ route('products.index') }}" class="text-black">
                        <div class="card radius-10">
                          <div class="card-body">
                              <div class="d-flex align-items-center">
                                  <div>
                                      <p class="mb-0 text-secondary">Total Products</p>
                                      <h4 class="my-1">{{ $totalProduct }}</h4>
                                  </div>
                                  <div class="widget-icon-large bg-gradient-danger text-white ms-auto"><i class="bi bi-list"></i>
                                  </div>
                              </div>
                          </div>
                      </div>
                    </a>
                  </div>
                  <div class="col">
                    <a href="{{ route('services.index') }}" class="text-black">
                        <div class="card radius-10">
                          <div class="card-body">
                              <div class="d-flex align-items-center">
                                  <div>
                                      <p class="mb-0 text-secondary">Total Services</p>
                                      <h4 class="my-1">{{ $totalService }}</h4>
                                  </div>
                                  <div class="widget-icon-large bg-gradient-info text-white ms-auto"><i class="bi bi-list"></i>
                                  </div>
                              </div>
                          </div>
                      </div>
                    </a>
                  </div>
              </div>

@endsection
