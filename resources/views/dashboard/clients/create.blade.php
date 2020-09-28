@extends('layouts.app')

@section('content')
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h2>{{ $pageTitle }}</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item "><a href="{{route('clientes')}}">Clientes</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Novo Cliente</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12">
            <div class="card planned_task">
                <div class="body">
                    <form action="{{ route('clientes.registrar') }}" method="post" id="frm_cadastro">
                        {{ @csrf_field() }}
                        <div class="row">
                            <div class="col-md-2">
                                <label for="app" class="control-label">APP</label>
                                <select name="app" class="form-control selectize @error('app') 'has-error' @enderror" required>
                                    <option value="">-- Selecione --</option>
                                    @foreach($players as $player)
                                        <option value="{{$player}}" {{old('app') == $player ? 'selected':''}}>{{$player}}</option>
                                    @endforeach
                                </select>
                                @error('app')
                                <code>{{ $message }}</code>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="method_payment" class="control-label">Forma Pagamento</label>
                                <select name="method_payment" class="form-control selectize @error('method_payment') 'has-error' @enderror" required>
                                    <option value="">-- Selecione --</option>
                                    <option value="Boleto">Boleto</option>
                                    <option value="Transferência">Transferência</option>
                                </select>
                                @error('method_payment')
                                    <code>{{ $message }}</code>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="monthly_payment" class="control-label">Mensalidade R$</label>
                                <input type="text" name="monthly_payment" id="monthly_payment" class="form-control" required value="{{old('cod')}}">
                                @error('method_payment')
                                <code>{{ $message }}</code>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <div class="form-group  @error('cod') 'has-error' @enderror">
                                    <label name="cod">Código/Login</label>
                                    <input type="text" name="cod" id="cod" class="form-control" required value="{{old('cod')}}">
                                    @error('cod')
                                    <code>{{ $message }}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group  @error('name') 'has-error' @enderror">
                                    <label name="name">Nome</label>
                                    <input type="text" name="name" id="name" class="form-control" required value="{{old('name')}}">
                                    @error('name')
                                    <code>{{ $message }}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group  @error('code_ssiptv') 'has-error' @enderror">
                                    <label name="code_ssiptv">Cód SS IPTV</label>
                                    <input type="text" name="code_ssiptv" id="code_ssiptv" class="form-control" placeholder="5HDE"  value="{{old('code_ssiptv')}}">
                                    @error('code_ssiptv')
                                    <code>{{ $message }}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group  @error('code_duplex') 'has-error' @enderror">
                                    <label name="code_duplex">Cód Duplex IPTV</label>
                                    <input type="text" name="code_duplex" id="code_duplex" class="form-control" placeholder="99:99:99:99:9b:99 / 99999"  value="{{old('code_duplex')}}">
                                    @error('code_ssiptv')
                                    <code>{{ $message }}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group  @error('email_smart_up') 'has-error' @enderror">
                                    <label name="email_smart_up">Smart STB</label>
                                    <input type="text" name="email_smart_up" id="email_smart_up" class="form-control" placeholder="emai@email.com / senha"  value="{{old('code_duplex')}}">
                                    @error('code_ssiptv')
                                    <code>{{ $message }}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group  @error('observations') 'has-error' @enderror">
                                    <label name="observations">Observação</label>
                                    <input type="text" name="observations" id="observations" class="form-control"  value="{{old('code_duplex')}}">
                                    @error('code_ssiptv')
                                    <code>{{ $message }}</code>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type='button' class="btn btn-outline-warning"
                                            onclick="location.href =  '{{url('clientes')}}' ">Voltar
                                    </button>
                                    <button type="submit" class="btn btn-outline-success mr-2 float-right">Salvar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')

@endsection
@section('scripts')
    <script type="text/javascript">

        $(function () {
            $('#frm_cadastro').parsley();
            $('#monthly_payment').maskMoney();
        });
    </script>

@endsection
