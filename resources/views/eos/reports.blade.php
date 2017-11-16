<table style="border-collapse: collapse; padding: 5px; font-family: arial; font-size: 14px; color: #fff;">
    <tr>
        <th style="background-color: #1975a5; padding: 10px; text-transform: uppercase;">Category</th>
        <th style="background-color: #1975a5; padding: 10px; text-transform: uppercase;">Count</th>
    </tr>
    
    <tr>
        <td style="border: 1px solid #C1DAD7; color: #4f6b72; font-size: 14px; font-family: arial; text-align: center; padding: 6px; text-align: left;">Hardware</td>
        <td style="border: 1px solid #C1DAD7; color: #4f6b72; font-size: 14px; font-family: arial; text-align: center; padding: 6px;">{{ $hardware }}</td>
    </tr>
    
    <tr>
        <td style="border: 1px solid #C1DAD7; color: #4f6b72; font-size: 14px; font-family: arial; text-align: center; padding: 6px; text-align: left;">Software</td>
        <td style="border: 1px solid #C1DAD7; color: #4f6b72; font-size: 14px; font-family: arial; text-align: center; padding: 6px;">{{ $software }}</td>
    </tr>
    
    <tr>
        <td style="border: 1px solid #C1DAD7; color: #4f6b72; font-size: 14px; font-family: arial; text-align: center; padding: 6px; text-align: left;">UPS</td>
        <td style="border: 1px solid #C1DAD7; color: #4f6b72; font-size: 14px; font-family: arial; text-align: center; padding: 6px;">{{ $ups }}</td>
    </tr>
    
    <tr>
        <td style="border: 1px solid #C1DAD7; color: #4f6b72; font-size: 14px; font-family: arial; text-align: center; padding: 6px; text-align: left;">Cosmocom</td>
        <td style="border: 1px solid #C1DAD7; color: #4f6b72; font-size: 14px; font-family: arial; text-align: center; padding: 6px;">{{ $cosmocom }}</td>
    </tr>
    
    <tr>
        <td style="border: 1px solid #C1DAD7; color: #4f6b72; font-size: 14px; font-family: arial; text-align: center; padding: 6px; text-align: left;">Network</td>
        <td style="border: 1px solid #C1DAD7; color: #4f6b72; font-size: 14px; font-family: arial; text-align: center; padding: 6px;">{{ $network }}</td>
    </tr>
    
    <tr>
        <td style="border: 1px solid #C1DAD7; color: #4f6b72; font-size: 14px; font-family: arial; text-align: center; padding: 6px; text-align: left;">Anti-Virus</td>
        <td style="border: 1px solid #C1DAD7; color: #4f6b72; font-size: 14px; font-family: arial; text-align: center; padding: 6px;">{{ $virus }}</td>
    </tr>
    
    <tr>
        <td style="border: 1px solid #C1DAD7; color: #4f6b72; font-size: 14px; font-family: arial; text-align: center; padding: 6px; text-align: left;">MIS/MIS-EWS</td>
        <td style="border: 1px solid #C1DAD7; color: #4f6b72; font-size: 14px; font-family: arial; text-align: center; padding: 6px;">{{ $mis }}</td>
    </tr>
    
    <tr>
        <td style="border: 1px solid #C1DAD7; color: #4f6b72; font-size: 14px; font-family: arial; text-align: center; padding: 6px; text-align: left;">TOTAL</td>
        <td style="border: 1px solid #C1DAD7; color: #4f6b72; font-size: 14px; font-family: arial; text-align: center; padding: 6px;">{{ $hardware + $software + $ups + $cosmocom + $network + $virus + $mis }}</td>
    </tr>
    
</table>