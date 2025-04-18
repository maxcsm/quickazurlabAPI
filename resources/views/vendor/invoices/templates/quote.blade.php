<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{{ $invoice->name }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <style type="text/css" media="screen">
            html {
                font-family: sans-serif;
                line-height: 1.15;
                margin: 0;
            }

            body {
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
                font-weight: 400;
                line-height: 1.5;
                color: #212529;
                background-color: #fff;
                font-size: 10px;
                margin: 36pt;
            }

            h4 {
                margin-top: 0;
                margin-bottom: 0.5rem;
            }

            p {
                margin-top: 0;
                margin-bottom: 1rem;
            }

            strong {
                font-weight: bolder;
            }

            img {
                vertical-align: middle;
                border-style: none;
            }

            table {
                border-collapse: collapse;
            }

            th {
                text-align: inherit;
            }

            h4, .h4 {
                margin-bottom: 0.5rem;
                font-weight: 500;
                line-height: 1.2;
            }

            h4, .h4 {
                font-size: 1.5rem;
            }

            .table {
                width: 100%;
                margin-bottom: 1rem;
                color: #212529;
            }

            .table th,
            .table td {
                padding: 0.75rem;
                vertical-align: top;
            }

            .table.table-items td {
                border-top: 1px solid #dee2e6;
            }

            .table thead th {
                vertical-align: bottom;
                border-bottom: 2px solid #dee2e6;
            }

            .mt-5 {
                margin-top: 3rem !important;
            }

            .pr-0,
            .px-0 {
                padding-right: 0 !important;
            }

            .pl-0,
            .px-0 {
                padding-left: 0 !important;
            }

            .text-right {
                text-align: right !important;
            }

            .text-center {
                text-align: center !important;
            }

            .text-uppercase {
                text-transform: uppercase !important;
            }
            * {
                font-family: "DejaVu Sans";
            }
            body, h1, h2, h3, h4, h5, h6, table, th, tr, td, p, div {
                line-height: 1.1;
            }
            .party-header {
                font-size: 1.5rem;
                font-weight: 400;
            }
            .total-amount {
                font-size: 12px;
                font-weight: 700;
            }
            .border-0 {
                border: none !important;
            }
            .cool-gray {
                color: #6B7280;
            }
        </style>
    </head>

    <body>
        {{-- Header --}}
        @if($invoice->logo)
            <img src="{{ $invoice->getLogo() }}" alt="logo" height="100">
        @endif

        <table class="table mt-1">
            <tbody>
                <tr>
                    <td class="border-0 pl-0" width="70%">
                        <h4 class="text-uppercase">
                            <strong>Devis N° {{ $invoice->getSerialNumber() }}</strong>
                        </h4>
                    </td>
                    <td class="border-0 pl-0">
                       
                  
                        <p> Date : <strong>{{ $invoice->getDate() }}</strong></p>
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- Seller - Buyer --}}
        <table class="table">
            <thead>
                <tr>
                    <th class="border-0 pl-0 party-header" width="48.5%">
                       
                    </th>
                    <th class="border-0" width="3%"></th>
                    <th class="border-0 pl-0 party-header">
                       Client
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="px-0">
                    
                            <p>
                            <strong>SPRL COPLATECK</strong> </br>
                            Rue des Alliés 302 </br>
                            Bruxelles</br>
                            TVA BE 0449.393.377 </br>
                            Compte bancaire : BE75 6430 0821 3351</br>
                            </p>
                    
                    </td>
                    <td class="border-0"></td>
                    <td class="px-0">
                 
                            <p class="buyer-name">
                                <strong>{{ $invoice->buyer->company }}</strong> </br>
                                <strong>{{ $invoice->buyer->lastname }} {{ $invoice->buyer->firstname }}</strong> </br>
                               <strong>   {{ $invoice->buyer->shipping_address }} </strong> </br>
                               <strong>   {{ $invoice->buyer->shipping_cp }},  {{ $invoice->buyer->shipping_city }}</strong> </br>
                                Tel :  {{ $invoice->buyer->shipping_phone }} </br>
                                Tel :  {{ $invoice->buyer->billing_phone }} </br>
                                TVA :  <strong> {{ $invoice->buyer->tva_number }}</strong> </br>
                              Siret :  <strong> {{ $invoice->buyer->siret_number }}</strong> </br>
                            </p>
                  
                       

                       
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- Table --}}
        <table class="table table-items">
            <thead>
                <tr>
                    <th scope="col" class="border-0 pl-0">{{ __('invoices::invoice.description') }}</th>
                    @if($invoice->hasItemUnits)
                        <th scope="col" class="text-center border-0">{{ __('invoices::invoice.units') }}</th>
                    @endif
                    <th scope="col" class="text-center border-0">Qte</th>
                    <th scope="col" class="text-right border-0">Prix </th>
                    @if($invoice->hasItemDiscount)
                        <th scope="col" class="text-right border-0">{{ __('invoices::invoice.discount') }}</th>
                    @endif
                    @if($invoice->hasItemTax)
                        <th scope="col" class="text-right border-0">{{ __('invoices::invoice.tax') }}</th>
                    @endif
                    <th scope="col" class="text-right border-0 pr-0">Sous total</th>
                </tr>
            </thead>
            <tbody>
                {{-- Items --}}
                @foreach($invoice->items as $item)
                <tr>
                    <td class="pl-0">
                        {{ $item->title }}

                        @if($item->description)

                        {!! $item->description!!} 
                        @endif
                    </td>
                    @if($invoice->hasItemUnits)
                        <td class="text-center">{{ $item->units }}</td>
                    @endif
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">
                        {{ $invoice->formatCurrency($item->price_per_unit) }}
                    </td>
                    @if($invoice->hasItemDiscount)
                        <td class="text-right">
                            {{ $invoice->formatCurrency($item->discount) }}
                        </td>
                    @endif
                    @if($invoice->hasItemTax)
                        <td class="text-right">
                            {{ $invoice->formatCurrency($item->tax) }}
                        </td>
                    @endif

                    <td class="text-right pr-0">
                        {{ $invoice->formatCurrency($item->sub_total_price) }}
                    </td>
                </tr>
                @endforeach
                {{-- Summary --}}
                @if($invoice->hasItemOrInvoiceDiscount())
                    <tr>
                        <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                        <td class="text-right pl-0">{{ __('invoices::invoice.total_discount') }}</td>
                        <td class="text-right pr-0">
                            {{ $invoice->formatCurrency($invoice->total_discount) }}
                        </td>
                    </tr>
                @endif
                @if($invoice->taxable_amount)
                    <tr>
                        <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                        <td class="text-right pl-0">Sous-total HT</td>
                        <td class="text-right pr-0">
                            {{ $invoice->formatCurrency($invoice->taxable_amount) }}
                        </td>
                    </tr>
                @endif
                @if($invoice->tax_rate)
                    <tr>
                        <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                        <td class="text-right pl-0">TVA</td>
                        <td class="text-right pr-0">
                            {{ $invoice->tax_rate }}%
                        </td>
                    </tr>
                @endif
                @if($invoice->hasItemOrInvoiceTax())
                    <tr>
                        <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                        <td class="text-right pl-0">Total TVA </td>
                        <td class="text-right pr-0">
                            {{ $invoice->formatCurrency($invoice->total_taxes) }}
                        </td>
                    </tr>
                @endif
                @if($invoice->shipping_amount)
                    <tr>
                        <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                        <td class="text-right pl-0">{{ __('invoices::invoice.shipping') }}</td>
                        <td class="text-right pr-0">
                            {{ $invoice->formatCurrency($invoice->shipping_amount) }}
                        </td>
                    </tr>
                @endif
                    <tr>
                        <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                        <td class="text-right pl-0">TOTAL </td>
                        <td class="text-right pr-0 total-amount">
                            {{ $invoice->formatCurrency($invoice->total_amount) }}
                        </td>
                    </tr>
            </tbody>
        </table>




<P><HR NOSHADE></P>


<p>
Conditions d’utilisation </p>
<p>    
1.	Les factures sont payables dés réception  après date de facturation. A défaut du paiement de la facture à son échéance, elle sera majorée sans mise en demeure préalable et dès la date d'échéance, d'un montant forfaitaire et irréductible de 15% avec un minimum de 50 EUR, à titre d'indemnité conventionnelle. En outre, les factures impayées à l'échéance porteront un intérêt conventionnel fixé à 1% par mois. 
</p>
<p>
2.	En cas de non-paiement des factures à leur échéance et dès que S.P.R.L COPLATECK se voit obligée d'entamer une procédure judiciaire en récupération des factures,  S.P.R.L COPLATECK se réserve le droit de suspendre l'exécution de ses propres obligations et d'arrêter ses prestations. Ces prestations ne seront reprises qu'après paiement intégral des factures non-payées, indemnités et intérêts conventionnels et les frais de justice, et ceci sous réserve du droit de la  S.P.R.L COPLATECK de considérer la convention résiliée aux torts et griefs du client.
</p>
       
<p>
3.	La S.P.R.L COPLATECK ne couvre que les dégâts matériels éventuellement causés par ses services. Ces dégâts doivent lui être signalés par lettre recommandée dans les 48 heures qui suivent les faits, sous peine de nullité. Au cas où  S.P.R.L COPLATECK n'aurait pas été mise en mesure d'opposer son propre constat des dégâts à la plainte du client, celle-ci sera considérée comme nulle de plein droit.
</p>
<p>    
4.	En cas de contestation, seuls les tribunaux de Bruxelles sont compétents.
</p>


<P><HR NOSHADE></P>


<p  class="text-center" >SRL COPLATECK 
RUE DES ALLIES 302
1190 FOREST
TVA BE 0449.393.377
02/5232189
0489/37950</p>

<p  class="text-center" > <b>Entreprise agréée par le Ministère de la Santé en Belgique Circuit Restreint Biocide </b> </p>
<p  class="text-center" > <b>Agrégation n° 2527/110287 - Tél: 02/5232189 Gsm: 0489/327950 </b> </p>






        <script type="text/php">
            if (isset($pdf) && $PAGE_COUNT > 1) {
                $text = "Page {PAGE_NUM} / {PAGE_COUNT}";
                $size = 10;
                $font = $fontMetrics->getFont("Verdana");
                $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
                $x = ($pdf->get_width() - $width);
                $y = $pdf->get_height() - 35;
                $pdf->page_text($x, $y, $text, $font, $size);
            }
        </script>
    </body>
</html>
