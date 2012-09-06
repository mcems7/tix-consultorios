<?=br(4)?>
<div id="firma">
<?=$medico['primer_nombre']." ".$medico['segundo_nombre']." ".$medico['primer_apellido']." ".$medico['segundo_apellido']?><br />
R.M:<?=nbs().$medico['tarjeta_profesional']?>
</div>            
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td id="pie"><?=$empresa['direccion'];?> <?=$empresa['municipio'];?> <?=$empresa['departamento'];?> Tel&eacute;fono <?=$empresa['telefono1'];?>  Fax. <?=$empresa['fax'];?> <br />
    <span style="text-decoration: underline;"><?=$empresa['email'];?></span></td>
    </tr>
  </table>
</body>
</html> 