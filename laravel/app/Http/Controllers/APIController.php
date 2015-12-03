<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use View, Auth;

class APIController extends BaseController
{
    public function sellOnEbay(Request $request){
        $uuid = md5(uniqid());

        $title = $request->get('titleBook');
        $price = $request->get('priceBook');

        // create the XML request
        $xmlRequest  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
        $xmlRequest .= "<AddItemRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">";
        $xmlRequest .= "<ErrorLanguage>en_US</ErrorLanguage>";
        $xmlRequest .= "<WarningLevel>High</WarningLevel>";
        $xmlRequest .= "<Item>";
        $xmlRequest .= "<Title>" . $title . "</Title>";
        $xmlRequest .= "<Description>Livre Coop</Description>";
        $xmlRequest .= "<PrimaryCategory>";
        $xmlRequest .= "<CategoryID>268</CategoryID>";
        $xmlRequest .= "</PrimaryCategory>";
        $xmlRequest .= "<StartPrice>" . $price . "</StartPrice>";
        $xmlRequest .= "<ConditionID>1000</ConditionID>";
        $xmlRequest .= "<CategoryMappingAllowed>true</CategoryMappingAllowed>";
        $xmlRequest .= "<Country>US</Country>";
        $xmlRequest .= "<Currency>USD</Currency>";
        $xmlRequest .= "<DispatchTimeMax>3</DispatchTimeMax>";
        $xmlRequest .= "<ListingDuration>Days_7</ListingDuration>";
        $xmlRequest .= "<ListingType>Chinese</ListingType>";
        $xmlRequest .= "<PaymentMethods>PayPal</PaymentMethods>";
        $xmlRequest .= "<PayPalEmailAddress>yourpaypal@emailaddress.com</PayPalEmailAddress>";
        $xmlRequest .= "<PostalCode>05485</PostalCode>";
        $xmlRequest .= "<Quantity>1</Quantity>";
        $xmlRequest .= "<ReturnPolicy>";
        $xmlRequest .= "<ReturnsAcceptedOption>ReturnsAccepted</ReturnsAcceptedOption>";
        $xmlRequest .= "<RefundOption>MoneyBack</RefundOption>";
        $xmlRequest .= "<ReturnsWithinOption>Days_30</ReturnsWithinOption>";
        $xmlRequest .= "<Description>Description</Description>";
        $xmlRequest .= "<ShippingCostPaidByOption>Buyer</ShippingCostPaidByOption>";
        $xmlRequest .= "</ReturnPolicy>";
        $xmlRequest .= "<ShippingDetails>";
        $xmlRequest .= "<ShippingType>Flat</ShippingType>";
        $xmlRequest .= "<ShippingServiceOptions>";
        $xmlRequest .= "<ShippingServicePriority>1</ShippingServicePriority>";
        $xmlRequest .= "<ShippingService>USPSMedia</ShippingService>";
        $xmlRequest .= "<ShippingServiceCost>2.50</ShippingServiceCost>";
        $xmlRequest .= "</ShippingServiceOptions>";
        $xmlRequest .= "</ShippingDetails>";
        $xmlRequest .= "<Site>US</Site>";
        $xmlRequest .= "<UUID>" . $uuid . "</UUID>";
        $xmlRequest .= "</Item>";
        $xmlRequest .= "<RequesterCredentials>";
        $xmlRequest .= "<eBayAuthToken>AgAAAA**AQAAAA**aAAAAA**c6hfVg**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4GhDpSEqQidj6x9nY+seQ**i6QDAA**AAMAAA**N6+iJCNSNE41KMognbtJUI+it+DFEe1NSEDa0q314yHvQe9M0rfeizkk4VCZ3HDsFJXSo2lD/6CTaY5FLL7Xo2yRhnC35IM7huViax9Jm/A9gCxWFqnSxmxSfqTCAurLNAyQSRV8B1M88KyD6CoX/qcET8Tv/Z+FmB2GW9XCvCwzzqKAkZX+emlqb4WbOXNE1xNG3WeentZSC//jvwJcVRj6mlmp9jTIE/MYgmcYnjSf0FbHSBWVbVhiIQUu2jiygSpaU7u60osQb/MbaEdVp82CwTu083QNf5JJOoVa1wB45eqkCCM6B8LNibn3Gs7o1pOWnbwzoYg7h0vtN4WAqs5qHxrR1fJ9PYZV3azs25voW2pGVIAxndXlNrEzTAVx2ky15zUHbZtDeSaVI1FDjNeT2OodGd3VDdh0Hyt74jusA2uln57tJragbU/2rVkb5Q7nG3sIvxSoaCG1RemfSPvDwhxkIS66fJe7TzqAIrXHoggm320PxSpgtLKlEQIcfEDCfsK1x4f7JI7WqryuNHZMoBycsGRKbXT3tgNFqfuwxP8SzJ/c3cIyx/zJW9PN4zQkueUAn8+OE2rZ/J9z7oWzqw6v//oadBJG8Rt+jivU5nnItQaaw0GFo3V+1lY4YIlrLuIMvmSV20w/HDX23JrgXER2DURnvH+bpif3920Ozo7OOsYPyfNryVJHF2Nc8NhV3vP7mk6d42UF8ty2tqFfawecUwja7XMcKGBOoYonbETri8CJoRJFFlRJXPHX</eBayAuthToken>";
        $xmlRequest .= "</RequesterCredentials>";
        $xmlRequest .= "<WarningLevel>High</WarningLevel>";
        $xmlRequest .= "</AddItemRequest>";

        $devname = "d9f0b890-1ce5-4e6e-83d5-e877b471e130";
        $appname = "TS5d6a596-9121-403e-9f89-b26dfadbe10";
        $certname = "bd08d6d9-a5be-4918-b665-b3eb3219438f";

        $headers = array(
            'X-EBAY-API-SITEID:0',
            'X-EBAY-API-CALL-NAME:AddItem',
            'X-EBAY-API-REQUEST-ENCODING:XML',
            'X-EBAY-API-COMPATIBILITY-LEVEL:947',
            'X-EBAY-API-DEV-NAME:' . $devname,
            'X-EBAY-API-APP-NAME:' . $appname,
            'X-EBAY-API-CERT-NAME:' . $certname,
            'Content-Type: text/xml;charset=utf-8'
        );

        // initialize our curl session
        $session  = curl_init("https://api.sandbox.ebay.com/ws/api.dll");
        // set our curl options with the XML request
        curl_setopt($session, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($session, CURLOPT_POST, true);
        curl_setopt($session, CURLOPT_POSTFIELDS, $xmlRequest);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        // execute the curl request
        $responseXML = curl_exec($session);

        print_r($responseXML);

        // close the curl session
        curl_close($session);
        // return the response XML
        return View::make('bookReservation')->with(['user' => Auth::user()->name, 'xmlEBay' => $responseXML]);
    }

    /**
     * Sends a json request to an ISBN database API
     * Returns with json string of all info available
     *
     * @param Request $request -> in this case ISBN number
     * @return View 'ajoutDeLivres' with Username and json array of api result
     */
    public function getIsbnBooks(Request $request){

        $isbn = $request->get('isbnText');
        $pageName = $request->get('pageName');

        $json = $this->getContentDataAttribute(file_get_contents("https://www.googleapis.com/books/v1/volumes?q=+isbn:".
            $isbn.
            "&key=AIzaSyBbtI1mN-lvCzHQrCxVel47M9IF4I9udL0&fiel".
            "ds=items/volumeInfo(title,authors,pageCount,indus".
            "tryIdentifiers),items/saleInfo/retailPrice/amount"));

        if($pageName == 'ajoutDeLivres')
            return View::make('ajoutDeLivres')->with(['user' => Auth::user()->name, 'jsonISBN' => $json]);
        elseif($pageName == 'bookReservation')
            return View::make('bookReservation')->with(['user' => Auth::user()->name, 'jsonISBN' => $json, 'emptyData' => 'true']);
    }

    /**
     * Sends a json request to a UPC database API
     * Returns with json string of all info available
     *
     * @param Request $request -> in this case UPC number
     * @return View 'ajoutDeLivres' with Username and json array of api result
     */
    public function getUpcBooks(Request $request){

        $isbn = $request->get('isbnText');

        $json = $this->getContentDataAttribute(file_get_contents('http://api.upcdatabase.org/json/9b2028c160f324a5a0ed889f07394e5d/' . $isbn));

        //return $json;

        return View::make('ajoutDeLivres')->with(['user' => Auth::user()->name, 'jsonUPC' => $json]);
    }

    /**
     * Sends a json request to an EAN database API
     * Returns with json string of all info available
     *
     * @param Request $request -> in this case EAN number
     * @return View 'ajoutDeLivres' with Username and json array of api result
     */
    public function getEanBooks(Request $request){

        $isbn = $request->get('isbnText');
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://api.outpan.com//v1/products/" . $isbn . "/name");
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_USERPWD, "0b8512a6b0bbaeae7977c53ce3157eb6:");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $json = curl_exec($curl);
        $json = $this->getContentDataAttribute($json);

        //return $json;

        return View::make('ajoutDeLivres')->with(['user' => Auth::user()->name, 'jsonEAN' => $json]);
    }

    /**
     * Decodes the json string and returns as an array
     *
     * @param $data -> json string from API
     * @return array from json
     */
    public function getContentDataAttribute($data){
        return json_decode($data, true);
    }
}