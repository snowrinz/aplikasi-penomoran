@extends('layouts.layout')

@section('title', $title)

@section('content')

@include('layouts.header')
@include('layouts.nav')

<h1 class="display-4">{{$title}}</h1>
<div class="row">
    <div class="col-3">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#RegisterAccessModal">Akses Baru</button>
    </div>
    {{-- <a href={{ action('UserController@accesslistregister', $username) }} class="btn btn-primary">Register New Access</a> --}}
    <div class="col-3">
    </div>
    <div class="col-6">
    <label for="show_data">Banyak Data :</label>
    <select name="show_data" id="show_data">
        <option selected value="5">5</option>
        <option value="2">2</option>
        <option value="50">50</option>
        <option value="100">100</option>
    </select>
    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
    <label for="filter_data">Filter Data :</label>
    <input type="hidden" name="page_hidden" id="page_hidden">
    <input type="hidden" name="url_hidden" id="url_hidden">
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="desc" />
    <input type="hidden" name="hidden_reverse_type" id="hidden_reverse_type" value="desc" />
    <input type="text" name="filter" id="filter" class="pl-2" placeholder="Cari Data">
    </div>
</div>

@if (count($access) > 0)
    <section class="access">
        @include('user.access.accesslist')
    </section>  
@endif

@include('user.modal.access.registermodal')
@include('user.modal.access.showmodal')
@include('user.modal.access.editmodal')
@include('user.modal.access.deletemodal')

<script>
$(document).ready(function () {
// pagination function start
    $('body').on('click', '.pagination a', function(e) {
        e.preventDefault();
        var url = $(this).attr('href').split('page=')[0];
        var url = url.replace('?', '');
        $('#url_hidden').val(url);
        var page = $(this).attr('href').split('page=')[1];
        $('#page_hidden').val(page);
        var query = $('#filter').val();  
        var show_data = $('#show_data').val();
        var column_name = $('#hidden_column_name').val();
        var order_type = $('#hidden_sort_type').val();
        fetch_data(url, page, query, column_name, order_type, show_data);
        window.history.pushState("", "", url);
    });
// pagination function ends

// banyak data
$('select[name="show_data"]').on('change', function (e) {
        $('#page_hidden').val('');
        var show_data = $('#show_data').val();
        var query = $('#filter').val();
        var page = "";
        var url = $('#url_hidden').val();
        var column_name = $('#hidden_column_name').val();
        var order_type = $('#hidden_sort_type').val();
        fetch_data(url, page, query, column_name, order_type, show_data);
    });


//search code start
    $('#filter').on('keyup',function(e) {
        $('#page_hidden').val('');
        var query = $('#filter').val();
        var page = "";
        var url = $('#url_hidden').val();
        var show_data = $('#show_data').val();
        var column_name = $('#hidden_column_name').val();
        var order_type = $('#hidden_sort_type').val();
        fetch_data(url, page, query, column_name, order_type, show_data);
// end search
    });

// filter 
$('body').on('click', '.sorting', function(){
        var column_name = $(this).data('column_name');
        var order_type = $('#hidden_reverse_type').val();
        var show_data = $('#show_data').val();
        var reverse_order = '';
        if (order_type == 'asc'){
            reverse_order = 'desc';
        }
        if(order_type == 'desc'){
            reverse_order = 'asc';  
        }
        $('#hidden_column_name').val(column_name);
        $('#hidden_sort_type').val(reverse_order);
        $('#hidden_reverse_type').val(reverse_order);
        $('#page_hidden').val('');
        var page = "";
        var query = $('#filter').val();
        var url = $('#url_hidden').val();
        fetch_data(url, page, query, column_name, reverse_order, show_data);
    });
//end filter

    function fetch_data(url, page, query='', column_name, order_type, show_data) {
        $.ajax({
            url : url + '?page=' + page + '&filter=' + query + '&sortby=' + column_name +'&sorttype=' + order_type + '&show_data=' + show_data,
            beforeSend : function(){
                $('.container-fluid').addClass('block');
                console.log(url);
            },
            complete : function(){
                $('.container-fluid').removeClass('block');
            },
        }).done(function (data) {
            $('.access').html(data);
            if (order_type == 'desc'){
                $('#'+column_name+'_icon').html('<i class="fa fa-caret-down" aria-hidden="true"></i>');
            }
            if (order_type == 'asc'){
                $('#'+column_name+'_icon').html('<i class="fa fa-caret-up" aria-hidden="true"></i>');
            }
        }).fail(function (data) {
            alert('Data Tidak Ditemukan');
        });
    }
});
</script>
@endsection
