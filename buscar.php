<?
	include "lib/class.php";
	//include('lib/sphinx/sphinxapi.php');

    $cl = new SphinxClient();
	$cl->SetServer( "localhost", 9312 );
	$cl->SetMatchMode( SPH_MATCH_ALL );
	$cl->SetFieldWeights( array ('b.titulo' => 10, 'b.descripcion' => 5, 'b.ciudad' => 6, 'b.urbanizacion' => 8, 'b.marca' => 8, 'b.modelo' => 8, 'b.anio' => 1) );
	$cl->SetLimits(0,1000,1000);
	
	
	$termino=$_GET['termino'];


    // el primer parámetro es la query, es lo que queremos buscar: cumpleaños
    // el segundo parámetro es el index que vamos a usar para buscarlo
    $result = $cl->Query( $termino, 'hispamercado' ); 

    if ( $result === false ) 
	{
		echo "fallo en Query: " . $cl->GetLastError() . "<br>";
    }
	else 
	{
		if ( $cl->GetLastWarning() ) 
		{
        	echo "WARNING: " . $cl->GetLastWarning() . "<br>";
		}
		
		if ( ! empty($result["matches"]) ) 
		{
			
			foreach ( $result["matches"] as $doc => $docinfo ) 
			{
				echo $doc."<br><br>";
			}

			
			//print_r( $result["matches"] );
		
			//echo count($result["matches"]);		
		}
		else
			echo "vacio";
    }

	
	
	
	

?>