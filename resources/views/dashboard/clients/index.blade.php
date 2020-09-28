@extends('layouts.app')

@section('content')
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h2>{{ $pageTitle }}</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item "><a href="{{route('clientes')}}">{{ $pageTitle }}</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12">
            @shield('clientes.create')
                <a href="{{route('clientes.create')}}" class="btn btn-outline-primary float-right mb-2">
                    <i class="fa fa-plus-circle"></i>&nbsp;@lang('messages.new')
                </a>
            @endshield
        </div>
        <div class="col-12">
            <div class="table-responsive">
                <table class="table header-border table-hover table-custom spacing5">
                    <thead>
                    <tr>
                        <th style="width:3%;">#</th>
                        <th>Nome</th>
                        <th>Prox Venc.</th>
                        <th>Meio Pagamento</th>
                        <th>Mensalidade</th>
                        <th>Responsável</th>
                        @for($i=1; $i<=12; $i++)
                            <th>{{\Carbon\Carbon::parse('2020-'.$i.'-1')->format('M')}}</th>
                        @endfor
                        <th style="width:10%;">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                       @foreach($clients as $client)
                            @php
                                $payments= \App\ZenSolutions\Services\Specializations\HistoryPayment\ReturnPaymentsClient::returnPayments($client->historyPayments);
                            @endphp
                            <tr>
                               <td>
                                   <a href="{{route('clientes.show',$client->cod)}}">
                                       {{$client->cod}}
                                   </a>
                               </td>
                               <td>{{$client->name}}</td>
                               <td>{{\Carbon\Carbon::parse($client->next_due_date)->format('d/m/Y')}}</td>
                               <td>{{$client->method_payment}}</td>
                               <td style="text-align: right;">{{number_format($client->monthly_payment,2,",",".")}}</td>
                               <td>{{$client->responsibleClient->name}}</td>
                               @foreach($payments as $key=>$payment)
                                    @if(isset($payment['style']))
                                        <td  style="{{$payment['style']}}">
                                            @if($payment['icon'] != "fa fa-ban" && $payment['icon'] != 'fa fa-check')
                                                <span style="cursor: pointer; display: block;padding: 20%;" class="btn-confirm" data-name="{{$client->name}}" data-client="{{$client->id}}" data-month="{{$key+1}}">
                                            @else
                                               <span style="display: block;padding: 20%;" >
                                            @endif
                                               <i class="{{$payment['icon']}}" aria-hidden="true"></i>
                                           </span>
                                        </td>
                                    @else
                                        <td>?</td>
                                    @endif
                                @endforeach
                               <td>
                                   @shield('clientes.edit')
                                       <a href="{{ route('clientes.editar', $client->id) }}"
                                          class="btn btn-outline-info" data-toggle="tooltip" title="{{ __('messages.edit') }}"
                                          data-placement="top">
                                           <i class="fa fa-edit"></i>
                                       </a>
                                   @endshield
                                   @shield('clientes.destroy')
                                       <a href="javascript:;"
                                          class="btn btn-outline-danger" data-toggle="tooltip" title="Excluír Cliente"
                                          data-placement="top"  onclick="event.preventDefault(); document.getElementById('excluir_{{$client->id}}').submit();">
                                           <i class="fa fa-trash"></i>
                                       </a>
                                       <form action="{{ url('clientes',$client->id) }}" method="post" id="excluir_{{$client->id}}" style="display:inline-block;">
                                           @csrf
                                           @method("DELETE")
                                       </form>
                                   @endshield
                               </td>
                           </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">

        $(function () {
            $('.btn-confirm').on('click',function () {
                let client = $(this).data('client')
                let month = $(this).data('month')
                let clientName = $(this).data('name')
                if (confirm(`Confirmar pagamento do mês para o cliente ${clientName}`)) {
                    axios.post('/clientes/confirm-payment',{clientId:client,month:month})
                        .then(success => {
                            window.location.href = '/clientes';
                        })
                        .catch(error => {
                            alert('Ocorreu um problema ao processar a requisição')
                        })
                } else {
                    alert('Processo cancelado!');
                }


            })
        });
    </script>

@endsection
