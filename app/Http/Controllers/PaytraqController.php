<?php

namespace App\Http\Controllers;

use App\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Request as Guzzle_Request;
use GuzzleHttp\Psr7\Stream;
use Psr\Http\Message\ResponseInterface;

class PaytraqController extends Controller
{
    protected $api_key = 'fb7f119b-f689-4a5e-9cfa-d75916e1924b-4175';
    protected $api_token = 'hoYGUHWwDlq6UGHg';
    protected $client_id = 116933;
    protected $group_ids = [
        '020' => '2561',
        '019' => '2562',
        '012' => '2563',
        '013' => '2564',
        '001' => '2565',
        '005' => '2567',
        '008' => '2568',
        '021' => '2569',
        '046' => '2570',
        '007' => '2571',
        '015' => '2572',
        '017' => '2573',
        '038' => '2574',
        '002' => '2575',
        '010' => '2576',
        '014' => '2577',
        '003' => '2578',
        '022' => '2579',
        '009' => '2580',
        '004' => '2581',
        '016' => '2582',
        '006' => '2583',
    ];

    public function index(Request $request)
    {
        $headers = ['Content-Type' => 'text/xml'];
        $body = "<Client>
                   <Name>$request->name</Name>
                   <Email>$request->email</Email>
                   <Type>$request->type</Type>
                   <Status>$request->status</Status>
                   <RegNumber>$request->reg_number</RegNumber>
                   <VatNumber>$request->vat_number</VatNumber>
                   <LegalAddress>
                      <Address>$request->address</Address>
                      <Zip>$request->zip</Zip>
                      <Country>$request->country</Country>
                   </LegalAddress>
                   <Phone>$request->phone</Phone>
                   <ClientGroup>
                      <GroupID>$request->group_id</GroupID>
                   </ClientGroup>
                </Client>";
        $client = new Client();
        $req = new Guzzle_Request('POST', "https://go.paytraq.com/api/client?APIToken=$this->api_token&APIKey=$this->api_key", $headers, $body);
        $response = $client->send($req);
        $body = json_decode(json_encode(simplexml_load_string((string) $response->getBody()->read(1024))), true);
        $user = User::create([
           'name' => $request->name,
           'email' => $request->email,
           'type' => $request->type,
           'status' => $request->status,
           'reg_number' => $request->reg_number,
           'vat_number' => $request->vat_number,
           'address' => $request->address,
           'zip' => $request->zip,
           'country' => $request->country,
           'phone' => $request->phone,
           'group_id' => $request->group_id,
           'paytraq_id' => $body['ClientID'],
        ]);

        return view('welcome2');
    }

    public function update_finans(Request $request)
    {
        $headers = ['Content-Type' => 'text/xml'];
        $body = "<Client>
                   <FinancialData>
                      <ContractNumber>$request->contract_number</ContractNumber>
                      <CreditLimit>$request->credit_limit</CreditLimit>
                      <Deposit>$request->deposit</Deposit>
                      <Discount>$request->discount</Discount>
                      <PayTerm>
                         <PayTermType>$request->pay_term_type</PayTermType>
                         <PayTermDays>$request->pay_term_days</PayTermDays>
                      </PayTerm>
                      <TaxKeys>
                         <Products>
                            <TaxKeyID>$request->products_tax_key_id</TaxKeyID>
                         </Products>
                         <Services>
                            <TaxKeyID>$request->services_tax_key_id</TaxKeyID>
                         </Services>
                      </TaxKeys>
                      <Warehouse>
                         <WrhID>$request->wrhID</WrhID>
                      </Warehouse>
                      <PriceGroup>
                         <PriceGroupID>$request->price_group_id</PriceGroupID>
                      </PriceGroup>
                   </FinancialData>
                </Client>";
        $client = new Client();
        $req = new Guzzle_Request('POST', "https://go.paytraq.com/api/client/financialData/$this->client_id?APIToken=$this->api_token&APIKey=$this->api_key", $headers, $body);
        $response = $client->send($req);
        $body = json_decode(json_encode(simplexml_load_string((string) $response->getBody()->read(1024))), true);

        $user = User::where('paytraq_id', $this->client_id)->update([
            'contract_number' => $request->contract_number,
            'credit_limit' => $request->credit_limit,
            'deposit' => $request->deposit,
            'discount' => $request->discount,
            'pay_term_type' => $request->pay_term_type,
            'pay_term_days' => $request->pay_term_days,
            'products_tax_key_id' => $request->products_tax_key_id,
            'services_tax_key_id' => $request->services_tax_key_id,
            'wrhID' => $request->wrhID,
            'price_group_id' => $request->price_group_id,
        ]);
        return redirect(route('main'));
    }

    public function main()
    {
//        2575
        $products = $this->get_products_by_group();


//        dd($products);


        $product_groups = $this->get_product_groups();
//        dd($products);
        return view('main', compact('product_groups', 'products'));
    }

    protected function client($url)
    {
        $client = new Client(['base_uri' => 'https://go.paytraq.com/api/']);
        $response = $client->get($url . "&APIToken=$this->api_token&APIKey=$this->api_key");

        return json_decode(json_encode(simplexml_load_string((string) $response->getBody()->read(1000000))), true);
    }


    public function get_product($product_id)
    {
        $url = "product/$product_id?";
        $product = $this->client($url);
//        dd($product['HasImage']);

        if($product['HasImage'] == 'true')
        {
//            dd($product);
            $image_url = "productImage/" . $product['ItemID'] . "?";
            $client = new Client(['base_uri' => 'https://go.paytraq.com/api/']);
            $response = $client->get($image_url . "&APIToken=$this->api_token&APIKey=$this->api_key");
            $product['image'] = base64_encode($response->getBody()->read(700000));
        }
//        dd($product);
        return $product;
//        return response()->json($product);
    }
    protected function get_product_groups()
    {
        $url = "productGroups?";
        return $this->client($url);
    }

    public function get_products_by_group($group_id = 0)
    {
        if($group_id == 0)
        {
            $url = "products?WarehouseID=1600";
            $all_products = $this->client($url);

            return $all_products;
        } else {
            $sku = array_search($group_id, $this->group_ids);
            $url = "products?query=$sku&WarehouseID=1600";
            $all_products_sku = $this->client($url);
            $group_products['Product'] = [];
            foreach ($all_products_sku['Product'] as $product)
            {
                if ($product['Group']['GroupID'] == $group_id)
                $group_products['Product'][] = $product;
            }
            return $group_products;
        }
    }
}
