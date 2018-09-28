@extends('layouts.layout')

@section('toolbar')
    <a class="btn" href="{{url('/W76F2251/add')}}">
        <i class="far fa-plus text-primary mgr5"></i>Tạo mới</a>

    <a class="btn" href="#">
        <i class="fal fa-reply text-orangered rotateY180"></i>  Chuyển tiếp</a>
@stop


@section('content')
    @parent
    <div class="row">
        <div class="col-sm-12">
            <div class="card">

                <div class="card-header hide">
                    <strong>Credit Card</strong>
                    <small>Form</small>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input class="form-control" id="name" type="text" placeholder="Enter your name">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="ccnumber">Credit Card Number</label>
                                <input class="form-control" id="ccnumber" type="text" placeholder="0000 0000 0000 0000">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="ccmonth">Month</label>
                            <select class="form-control" id="ccmonth">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                                <option>7</option>
                                <option>8</option>
                                <option>9</option>
                                <option>10</option>
                                <option>11</option>
                                <option>12</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="ccyear">Year</label>
                            <select class="form-control" id="ccyear">
                                <option>2014</option>
                                <option>2015</option>
                                <option>2016</option>
                                <option>2017</option>
                                <option>2018</option>
                                <option>2019</option>
                                <option>2020</option>
                                <option>2021</option>
                                <option>2022</option>
                                <option>2023</option>
                                <option>2024</option>
                                <option>2025</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="cvv">CVV/CVC</label>
                                <input class="form-control" id="cvv" type="text" placeholder="123">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop
