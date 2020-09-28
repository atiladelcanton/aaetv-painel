<?php


namespace App\Http\Controllers;


use App\Http\Requests\ClientStore;
use App\ZenSolutions\Helpers\LogError;
use App\ZenSolutions\Helpers\Players;
use App\ZenSolutions\Helpers\SessionFlashMessage;
use App\ZenSolutions\Services\Specializations\HistoryPayment\ProcessPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    private $client;

    function __construct()
    {
        $this->client = app()->make('App\ZenSolutions\Services\ClientService');
    }

    public function index(){
        $clients = $this->client->renderList('name');
        $pageTitle = 'Listagem Clientes';
        return view('dashboard.clients.index', compact('clients', 'pageTitle'));
    }

    public function create(){
        $pageTitle = 'Novo Cliente';
        $players = Players::renderPlayers();

        return view('dashboard.clients.create', compact( 'pageTitle','players'));
    }

    public function store(ClientStore  $request){
        try{
            DB::beginTransaction();
            $data = $request->all();

            $this->client->buildInsert($data);
            DB::commit();
            $request->session()->flash('message', ['type' => 'Success', 'msg' => __('messages.success_store')]);
            return redirect()->route('clientes');
        }catch (\Exception $exception){
            DB::rollBack();
            LogError::Log($exception);
            $request->session()->flash('message', ['type' => 'Error', 'msg' => 'Ocorreu um erro ao inserir o Cliente']);
            return back()->withInput();
        }
    }

    public function edit($clientId){

        $players = Players::renderPlayers();
        $client = $this->client->renderEdit($clientId);
        $pageTitle = 'Editar Cliente '.$client->name;
        return view('dashboard.clients.edit', compact( 'pageTitle','players','client'));
    }

    public function update($clientId,ClientStore  $request){
        try{
            DB::beginTransaction();
            $data = $request->all();

            $this->client->buildUpdate($clientId,$data);
            DB::commit();
            $request->session()->flash('message', ['type' => 'Success', 'msg' => __('messages.success_update')]);
            return redirect()->route('clientes');
        }catch (\Exception $exception){
            DB::rollBack();
            LogError::Log($exception);
            $request->session()->flash('message', ['type' => 'Error', 'msg' => 'Ocorreu um erro ao atualizar o Cliente']);
            return back()->withInput();
        }
    }

    public function destroy($clientId){
        try {
            $user = $this->client->renderEdit($clientId);
            if (is_null($user)) {
                SessionFlashMessage::error(SessionFlashMessage::DESTROY);
                return redirect()->route('clientes');
            }

            $this->client->buildDelete($clientId);
            session()->flash('message', ['type' => 'Success', 'msg' => 'Cliente removido com sucesso!']);
            return redirect()->route('clientes');
        } catch (\Exception $exception) {
            LogError::Log($exception);
            SessionFlashMessage::error(SessionFlashMessage::DESTROY);
            return redirect()->route('clientes');
        }
    }

    public function confirmPayment(Request  $request){
        try{

            DB::beginTransaction();
            $data = $request->all();
            $nextDueDate = ProcessPayment::process($request->clientId,$request->month);

            if($nextDueDate){
                $this->client->updateNextDueDate($request->clientId,$nextDueDate);
            }
            DB::commit();
            $request->session()->flash('message', ['type' => 'Success', 'msg' => 'Pagamento Confirmado']);
            return  response()->json(['data'=>'Pagamento confirmado'],200);
        }catch (\Exception $exception){
            DB::rollBack();
            LogError::Log($exception);
            $request->session()->flash('message', ['type' => 'Error', 'msg' => 'Ocorreu um erro ao registrar o pagamento']);
            return  response()->json(['data'=>'Ocorreu um problema ao processar o pagamento'],500);
        }
    }
}
