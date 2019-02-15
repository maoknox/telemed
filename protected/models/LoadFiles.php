<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class LoadFiles extends CFormModel{
    public function loadDepartamento($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO departamento (idvar_departamento,nombre_departamento) VALUES (:idvar_departamento,:nombre_departamento)";
        $numRows= count($data->sheets[0]['cells']);
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $modelDepartamento= Departamento::model()->findByAttributes(array("idvar_departamento"=>$data[1]));
                if(empty($modelDepartamento) || !is_object($modelDepartamento)){
                   $query->bindParam(":idvar_departamento",$data[1]);
                   $query->bindValue(":nombre_departamento",utf8_encode($data[2]));
                   $query->execute(); 
                }
            }
        }
    }
    public function loadMarca($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO marca (nombre_marca) VALUES (:nombre_marca)";
        $numRows= count($data->sheets[0]['cells']);
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $data[2]=utf8_encode($data[2]);
                $modelMarca= Marca::model()->findByAttributes(array("nombre_marca"=>utf8_encode($data[2])));
                if(empty($modelMarca) || !is_object($modelMarca)){
                   $query->bindValue(":nombre_marca",$data[2]);
                   $query->execute(); 
                }
            }
        }
    }
    public function loadGenero($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO genero (nombre_genero) VALUES (:nombre_genero)";
        $numRows= count($data->sheets[0]['cells']);
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $data[2]=utf8_encode($data[2]);
                $model= Genero::model()->findByAttributes(array("nombre_genero"=>utf8_encode($data[2])));
                if(empty($model) || !is_object($model)){
                   $query->bindValue(":nombre_genero",$data[2]);
                   $query->execute(); 
                }
            }
        }
    }
    public function loadGrse($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO grse (nombre_grse) VALUES (:nombre_grse)";
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $data[2]=utf8_encode($data[2]);
                $model= Grse::model()->findByAttributes(array("nombre_grse"=>utf8_encode($data[2])));
                if(empty($model) || !is_object($model)){
                   $query->bindValue(":nombre_grse",$data[2]);
                   $query->execute(); 
                }
            }
        }
    }
    public function loadCocaNombre($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO coca_nombre (nombre_coca) VALUES (:nombre_coca)";
        $numRows= count($data->sheets[0]['cells']);
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $data[2]=utf8_encode($data[2]);
                $model= CocaNombre::model()->findByAttributes(array("nombre_coca"=>utf8_encode($data[2])));
                if(empty($model) || !is_object($model)){
                   $query->bindValue(":nombre_coca",$data[2]);
                   $query->execute(); 
                }
            }
        }
    }
    
    public function loadGrupoCapacidad($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO grupo_capacidad (nombre_grupocap) VALUES (:nombre_grupocap)";
        $numRows= count($data->sheets[0]['cells']);
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $data[2]=utf8_encode($data[2]);
                $model= GrupoCapacidad::model()->findByAttributes(array("nombre_grupocap"=>utf8_encode($data[2])));
                if(empty($model) || !is_object($model)){
                   $query->bindValue(":nombre_grupocap",$data[2]);
                   $query->execute(); 
                }
            }
        }
    }
    public function loadModalidad($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO modalidad (nombre_modalidad) VALUES (:nombre_modalidad)";
        $numRows= count($data->sheets[0]['cells']);
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $data[2]=utf8_encode($data[2]);
                $model= Modalidad::model()->findByAttributes(array("nombre_modalidad"=>utf8_encode($data[2])));
                if(empty($model) || !is_object($model)){
                   $query->bindValue(":nombre_modalidad",$data[2]);
                   $query->execute(); 
                }
            }
        }
    }
    public function loadNaturalezaJuridica($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO naturaleza_juridica (naturaleza_juridica) VALUES (:naturaleza_juridica)";
        $numRows= count($data->sheets[0]['cells']);
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $data[2]=utf8_encode($data[2]);
                $model= NaturalezaJuridica::model()->findByAttributes(array("naturaleza_juridica"=>utf8_encode($data[2])));
                if(empty($model) || !is_object($model)){
                   $query->bindValue(":naturaleza_juridica",$data[2]);
                   $query->execute(); 
                }
            }
        }
    }
    public function loadTipoImplemento($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO tipo_implemento (id_tipoimplemento,tipo_implemento) VALUES (:id_tipoimplemento,:tipo_implemento)";
        $numRows= count($data->sheets[0]['cells']);
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $data[2]=utf8_encode($data[2]);
                $model= TipoImplemento::model()->findByAttributes(array("tipo_implemento"=>utf8_encode($data[2])));
                if(empty($model) || !is_object($model)){
                   $query->bindParam(":id_tipoimplemento",$data[1]);
                   $query->bindValue(":tipo_implemento",$data[2]);
                   $query->execute(); 
                }
            }
        }
    }
    public function loadNivelAtencion($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO nivel_atencion (id_nivelatencion,nivel_atencion) VALUES (:id_nivelatencion,:nivel_atencion)";
        $numRows= count($data->sheets[0]['cells']);
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $data[2]=utf8_encode($data[2]);
                $model= NivelAtencion::model()->findByAttributes(array("nivel_atencion"=>utf8_encode($data[2])));
                if(empty($model) || !is_object($model)){
                   $query->bindParam(":id_nivelatencion",$data[1]);
                   $query->bindValue(":nivel_atencion",$data[2]);
                   $query->execute(); 
                }
            }
        }
    }
    public function loadTipoPoblacion($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO tipo_poblacion (tipo_poblacion) VALUES (:tipo_poblacion)";
        $numRows= count($data->sheets[0]['cells']);
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $data[2]=utf8_encode($data[2]);
                $model= TipoPoblacion::model()->findByAttributes(array("tipo_poblacion"=>utf8_encode($data[2])));
                if(empty($model) || !is_object($model)){
                   $query->bindValue(":tipo_poblacion",$data[2]);
                   $query->execute(); 
                }
            }
        }
    }
    public function loadClasePrestador($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO clase_prestador (id_claseprestador,clase_prestador) VALUES (:id_claseprestador,:clase_prestador)";
        $numRows= count($data->sheets[0]['cells']);
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $data[2]=utf8_encode($data[2]);
                $model= ClasePrestador::model()->findByAttributes(array("clase_prestador"=>utf8_encode($data[2])));
                if(empty($model) || !is_object($model)){
                   $query->bindParam(":id_claseprestador",$data[1]);
                   $query->bindValue(":clase_prestador",$data[2]);
                   $query->execute(); 
                }
            }
        }
    }
    public function loadTipoServicio($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO tipo_servicio (codigo_servicio,tipo_servicio) VALUES (:codigo_servicio,:tipo_servicio)";
        $numRows= count($data->sheets[0]['cells']);
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $data[2]=utf8_encode($data[2]);
                $model= TipoServicio::model()->findByAttributes(array("tipo_servicio"=>utf8_encode($data[2])));
                if(empty($model) || !is_object($model)){
                   $query->bindParam(":codigo_servicio",$data[1]);
                   $query->bindValue(":tipo_servicio",$data[2]);
                   $query->execute(); 
                }
            }
        }
    }public function loadTipoAfiliado($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO tipo_afiliado (tipo_afiliado) VALUES (:tipo_afiliado)";
        $numRows= count($data->sheets[0]['cells']);
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $data[2]=utf8_encode($data[2]);
                $model= TipoAfiliado::model()->findByAttributes(array("tipo_afiliado"=>utf8_encode($data[2])));
                if(empty($model) || !is_object($model)){
                   $query->bindValue(":tipo_afiliado",$data[2]);
                   $query->execute(); 
                }
            }
        }
    }
    public function loadSeccion($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO seccion (idvar_seccion,nombre_seccion) VALUES (:idvar_seccion,:nombre_seccion)";
        $numRows= count($data->sheets[0]['cells']);
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $data[2]=utf8_encode($data[2]);
                $modelMarca= Seccion::model()->findByAttributes(array("idvar_seccion"=>utf8_encode($data[1])));
                if(empty($modelMarca) || !is_object($modelMarca)){
                   $query->bindParam(":idvar_seccion",$data[1]);
                   $query->bindValue(":nombre_seccion",$data[2]);
                   $query->execute(); 
                }
            }
        }
    }
    public function loadModelo($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO modelo (nombre_modelo) VALUES (:nombre_modelo)";
        $numRows= count($data->sheets[0]['cells']);
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $data[2]=utf8_encode($data[2]);
                $modelModelo= Modelo::model()->findByAttributes(array("nombre_modelo"=>utf8_encode($data[2])));
                if(empty($modelModelo) || !is_object($modelModelo)){
                   $query->bindValue(":nombre_modelo",$data[2]);
                   $query->execute(); 
                }
            }
        }
    }
    public function loadReferencia($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO referencia (nombre_referencia) VALUES (:nombre_referencia)";
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $data[2]=utf8_encode($data[2]);
                $modelRerferencia= Referencia::model()->findByAttributes(array("nombre_referencia"=>utf8_encode($data[2])));
                if(empty($modelRerferencia) || !is_object($modelRerferencia)){
                   $query->bindValue(":nombre_referencia",$data[2]);
                   $query->execute(); 
                }
            }
        }
    }
    public function loadTecnicaDiagnostico($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO tecnica_diagnostico (nombre_tecnica) VALUES (:nombre_tecnica)";
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $data[2]=utf8_encode($data[2]);
                $modelTecnicaDiagnostico= TecnicaDiagnostico::model()->findByAttributes(array("nombre_tecnica"=>utf8_encode($data[2])));
                if(empty($modelTecnicaDiagnostico) || !is_object($modelTecnicaDiagnostico)){
                   $query->bindValue(":nombre_tecnica",$data[2]);
                   $query->execute(); 
                }
            }
        }
    }
    
    public function loadProveedor($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO proveedor (nombre_proveedor) VALUES (:nombre_proveedor)";
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $data[2]=utf8_encode($data[2]);
                $modelProveedor= Proveedor::model()->findByAttributes(array("nombre_proveedor"=>utf8_encode($data[2])));
                if(empty($modelProveedor) || !is_object($modelProveedor)){
                   $query->bindValue(":nombre_proveedor",$data[2]);
                   $query->execute(); 
                }
            }
        }
    }
    public function loadQuinquenio($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO quinquenio (tipo_quinquenio) VALUES (:tipo_quinquenio)";
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $data[2]=utf8_encode($data[2]);
                $modelQuinquenio= Quinquenio::model()->findByAttributes(array("tipo_quinquenio"=>utf8_encode($data[2])));
                if(empty($modelQuinquenio) || !is_object($modelQuinquenio)){
                   $query->bindValue(":tipo_quinquenio",$data[2]);
                   $query->execute(); 
                }
            }
        }
    }
    public function loadTipoUsuario($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO tipo_usuario (tipo_usuario) VALUES (:tipo_usuario)";
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $data[2]=utf8_encode($data[2]);
                $modelTipoUsuario= TipoUsuario::model()->findByAttributes(array("tipo_usuario"=>utf8_encode($data[2])));
                if(empty($modelTipoUsuario) || !is_object($modelTipoUsuario)){
                   $query->bindValue(":tipo_usuario",$data[2]);
                   $query->execute(); 
                }
            }
        }
    }
    public function loadGrupoProducto($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO grupo_producto (nombre_grupoproducto) VALUES (:nombre_grupoproducto)";
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $data[2]=mb_strtoupper(utf8_encode(trim($data[2])));
                $modelGrupoProducto= GrupoProducto::model()->findByAttributes(array("nombre_grupoproducto"=>utf8_encode($data[2])));
                if(empty($modelGrupoProducto) || !is_object($modelGrupoProducto)){
                   $query->bindValue(":nombre_grupoproducto",$data[2]);
                   $query->execute(); 
                }
            }
        }
    }
    public function loadZona($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO zona (nombre_zona) VALUES (:nombre_zona)";
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $data[2]=utf8_encode($data[2]);
                $modelZona= Zona::model()->findByAttributes(array("nombre_zona"=>utf8_encode($data[2])));
                if(empty($modelZona) || !is_object($modelZona)){
                   $query->bindValue(":nombre_zona",$data[2]);
                   $query->execute(); 
                }
            }
        }
    }
    public function loadGrupoPoblacional($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO grupo_poblacional (nombre_grupopoblacional) VALUES (:nombre_grupopoblacional)";
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $data[2]=utf8_encode($data[2]);
                $modelGrupoPoblacional= GrupoPoblacional::model()->findByAttributes(array("nombre_grupopoblacional"=>utf8_encode($data[2])));
                if(empty($modelGrupoPoblacional) || !is_object($modelGrupoPoblacional)){
                   $query->bindValue(":nombre_grupopoblacional",$data[2]);
                   $query->execute(); 
                }
            }
        }
    }
    public function loadTipoAdministrador($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO tipo_administrador (tipo_administrador,codigo_administrador) VALUES (:tipo_administrador,:codigo_administrador)";
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $data[2]=utf8_encode($data[2]);
                $modelTipoAdmnistrador= TipoAdministrador::model()->findByAttributes(array("tipo_administrador"=>utf8_encode($data[2])));
                $data[2]=utf8_encode($data[2]);
                if(empty($modelTipoAdmnistrador) || !is_object($modelTipoAdmnistrador)){
                   $query->bindValue(":tipo_administrador",$data[2]);
                   $query->bindValue(":codigo_administrador",$data[1]);
                   $query->execute(); 
                }
            }
        }
    }
    public function loadRegimenAdministrador($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO regimen_administrador (regimen_administrador) VALUES (:regimen_administrador)";
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $data[2]=utf8_encode($data[2]);
                $modelRegimenAdministrador= RegimenAdministrador::model()->findByAttributes(array("regimen_administrador"=>utf8_encode($data[2])));
                if(empty($modelRegimenAdministrador) || !is_object($modelRegimenAdministrador)){
                   $query->bindValue(":regimen_administrador",$data[2]);
                   $query->execute(); 
                }
            }
        }
    }
    public function loadAdministrador($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO administrador (id_tipoadministrador,codigo_eps,nombre_admin) VALUES (:id_tipoadministrador,:codigo_eps,:nombre_admin)";
        $numRows= count($data->sheets[0]['cells']);
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        $varSalida="";
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $modelAdministrador= Administrador::model()->findByAttributes(array("codigo_eps"=>trim(utf8_encode($data[2]))));
                if(empty($modelAdministrador) || !is_object($modelAdministrador)){
                    try{
                        $modelTipoAdministrador= TipoAdministrador::model()->findByAttributes(array("codigo_administrador"=>$data[1]));
                        if(empty($modelTipoAdministrador)&& !is_object($modelTipoAdministrador)){throw new Exception("2");}else{$data[1]=$modelTipoAdministrador->id_tipoadministrador;}
                        (empty($data[3]))?$data[3]="":$data[3]=utf8_encode($data[3]);
                        $query->bindParam(":id_tipoadministrador",$data[1]);
                        $query->bindParam(":codigo_eps",$data[2]);
                        $query->bindParam(":nombre_admin",$data[3]);
                        $query->execute();
                    }
                    catch(Exception $e){
                        $registro=$pk+1;
                        $varSalida.="No se cargó el registro No. ".$pk." error en el campo No. ".$e->getMessage();
                        $varSalida.="\n---------------------\n";
                    }
                }
            }
        }
        return $varSalida;
    }
    public function loadAdministradorVsPrestador($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO administrador_prestador (id_admin,id_prestador) VALUES (:id_admin,:id_prestador)";
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        $varSalida="";
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $modelAdministrador= Administrador::model()->findByAttributes(array("codigo_eps"=>$data[1]));
                $modelPrestador= Prestador::model()->findByAttributes(array("codigo_prestador"=>$data[2]));
                if(!empty($modelPrestador) && !empty($modelAdministrador)){
                    $modelAdminPrestador= AdministradorPrestador::model()->findByAttributes(array("id_admin"=>$modelAdministrador->id_admin,"id_prestador"=>$modelPrestador->id_prestador));
                }
                try{
                    if(empty($modelPrestador)&& !is_object($modelPrestador)){throw new Exception("2");}else{$data[2]=$modelPrestador->id_prestador;}
                    if(empty($modelAdministrador)&& !is_object($modelAdministrador)){throw new Exception("1");}else{$data[1]=$modelAdministrador->id_admin;}
                    if(!empty($modelAdminPrestador)&& is_object($modelAdminPrestador)){throw new Exception("Relación registrada con anterioridad");}
                    $data[1]=$modelAdministrador->id_admin;
                    $data[2]=$modelPrestador->id_prestador;      
                    $query->bindParam(":id_admin",$data[1]);
                    $query->bindParam(":id_prestador",$data[2]);
                    $query->execute(); 
                }
                catch(Exception $e){
                    $registro=$pk+1;
                    $varSalida.="No se cargó el registro No. ".$pk." error en el campo No. ".$e->getMessage();
                    $varSalida.="\n---------------------\n";
                }
            }
        }
        return $varSalida;
    }
    
    public function loadAdministradorRegimen($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO administrador_regimen (id_admin,id_regimenadmon) VALUES (:id_admin,:id_regimenadmon)";
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        $varSalida="";
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $modelAdministrador= Administrador::model()->findByAttributes(array("codigo_eps"=>$data[2]));
                $modelRegimenAdmon= RegimenAdministrador::model()->findByAttributes(array("id_regimenadmon"=>$data[1]));
                if(!empty($modelAdministrador) && !empty($modelRegimenAdmon)){
                    $modelAdminRegimen= AdministradorRegimen::model()->findByAttributes(array("id_admin"=>$modelAdministrador->id_admin,"id_regimenadmon"=>$modelRegimenAdmon->id_regimenadmon));                   
                }//print_r($modelRegimenAdmon);exit();
                try{
                    if(empty($modelAdministrador)&& !is_object($modelAdministrador)){throw new Exception("2");}else{$data[2]=$modelAdministrador->id_admin;}
                    if(empty($modelRegimenAdmon)&& !is_object($modelRegimenAdmon)){throw new Exception("1");}else{$data[1]=$modelRegimenAdmon->id_regimenadmon;}
                    if(!empty($modelAdminRegimen)&& is_object($modelAdminRegimen)){throw new Exception("Relación registrada con anterioridad");}
                    $data[2]=$modelAdministrador->id_admin;
                    $data[1]=$modelRegimenAdmon->id_regimenadmon;      
                    $query->bindParam(":id_admin",$data[2]);
                    $query->bindParam(":id_regimenadmon",$data[1]);
                    $query->execute(); 
                }
                catch(Exception $e){
                    $registro=$pk+1;
                    $varSalida.="No se cargó el registro No. ".$pk." error en el campo No. ".$e->getMessage();
                    $varSalida.="\n---------------------\n";
                }
            }
        }
        return $varSalida;
    }
    
    public function loadSubgrupoProducto($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO subgrupo_producto (id_grupoproducto,nombre_subgrupoproducto) VALUES (:id_grupoproducto,:nombre_subgrupoproducto)";
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        $varSalida="";
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $data[2]= mb_strtoupper(utf8_decode(trim($data[2])));
                $data[3]= mb_strtoupper(utf8_decode(trim($data[3])));
                $modeloGrupoProducto= GrupoProducto::model()->findByAttributes(array("id_grupoproducto"=>$data[2]));
                $modelSubgrupoProduto= SubgrupoProducto::model()->findByAttributes(array("nombre_subgrupoproducto"=>$data[3]));
                try{
                    if(empty($modeloGrupoProducto)&& !is_object($modeloGrupoProducto)){throw new Exception("2");}else{$data[2]=$modeloGrupoProducto->id_grupoproducto;}
                    if(!empty($modelSubgrupoProduto)&& is_object($modelSubgrupoProduto)){throw new Exception("Subgrupo de producto registrado con anterioridad");}
                    $query->bindParam(":id_grupoproducto",$data[2]);
                    $query->bindParam(":nombre_subgrupoproducto",$data[3]);
                    $query->execute();
                }
                catch(Exception $e){
                    $registro=$pk+1;
                    $varSalida.="No se cargó el registro No. ".$pk." error en el campo No. ".$e->getMessage();
                    $varSalida.="\n---------------------\n";
                }
            }
        }
        return $varSalida;
    }
    public function loadCategoriaProducto($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO categoria_producto (id_subgrupoproducto,nombre_categoriaproducto) VALUES (:id_subgrupoproducto,:nombre_categoriaproducto)";
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        $varSalida="";
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $data[2]= mb_strtoupper(utf8_decode(trim($data[2])));
                $data[3]= mb_strtoupper(utf8_decode(trim($data[3])));
                $modeloSubgruProducto= SubgrupoProducto::model()->findByAttributes(array("id_subgrupoproducto"=>$data[2]));
                $modelCategoriaProducto= CategoriaProducto::model()->findBySql("SELECT * FROM categoria_producto where id_subgrupoproducto=:id_subgrupoproducto and nombre_categoriaproducto=:nombre_categoriaproducto;",array(":nombre_categoriaproducto"=>$data[3],":id_subgrupoproducto"=>$data[2]));
                try{
                    if(empty($modeloSubgruProducto)&& !is_object($modeloSubgruProducto)){throw new Exception("2");}else{$data[2]=$modeloSubgruProducto->id_subgrupoproducto;}
                    if(!empty($modelCategoriaProducto)&& is_object($modelCategoriaProducto)){throw new Exception("Categoría de producto registrado con anterioridad");}
                    $query->bindParam(":id_subgrupoproducto",$data[2]);
                    $query->bindParam(":nombre_categoriaproducto",$data[3]);
                    $query->execute();
                }
                catch(Exception $e){
                    $registro=$pk+1;
                    $varSalida.="No se cargó el registro No. ".$pk." error en el campo No. ".$e->getMessage();
                    $varSalida.="\n---------------------\n";
                }
            }
        }
        return $varSalida;
    }
    public function loadAdministradorMunicipio($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO administrador_municipio (id_admin,id_municipio) VALUES (:id_admin,:id_municipio)";
        $numRows= count($data->sheets[0]['cells']);
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $modelAdministradorMunicipio= Administrador::model()->findByAttributes(array("id_admin"=>$data[1],"id_municipio"=>$data[2]));
                if(empty($modelAdministradorMunicipio) || !is_object($modelAdministradorMunicipio)){
                    $modelAdministrador=Administrador::model()->findByAttributes(array("id_admin"=>$data[1]));
                    $modelMunicipio=Municipio::model()->findByAttributes(array("idvar_municipio"=>$data[2]));
                    $data[1]=$modelAdministrador->id_admin;
                    $data[2]=$modelMunicipio->id_municipio;
                    if(!empty($modelAdministrador) && is_object($modelAdministrador) && !empty($modelMunicipio) && is_object($modelMunicipio)){
                        $query->bindParam(":id_admin",$data[1]);
                        $query->bindParam(":idvar_municipio",$data[2]);
                        $query->execute(); 
                    }
                }
            }
        }
    }
    
    public function loadServicioPrestador($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $datai=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO servicio_prestador (id_prestador,id_tiposervicio,id_grse,ese,nivel,"
                . "caracter,habilitado,ambulatorio,hospitalario,unidad_movil,domiciliario,"
                . "otras_extramural,centro_referencia,institucion_remisora,complejidad_baja,"
                . "complejidad_media,complejidad_alta,fecha_apertura,fecha_cierre,numero_distintivo,numero_sede_principal,fecha_corte_resp"
                . ") VALUES (:id_prestador,:id_tiposervicio,:id_grse,:ese,:nivel,"
                . ":caracter,:habilitado,:ambulatorio,:hospitalario,:unidad_movil,:domiciliario,"
                . ":otrase_extramural,:centro_referencia,:institucion_remisora,:complejidad_baja,"
                . ":complejidad_media,:complejidad_alta,:fecha_apertura,:fecha_cierre,:numero_distintivo,:numero_sede_principal,:fecha_corte_resp"
                . ")";
        $numRows= count($datai->sheets[0]['cells']);
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        $varSalida="";
        foreach($datai->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
//            $modelServicioPrestador= ServicioPrestador::model()->findByAttributes(array("numero_distintivo"=>$data[20]));
//                if(empty($modelServicioPrestador) || !is_object($modelServicioPrestador)){
                    try{
                        $modelPrestador= Prestador::model()->findByAttributes(array("codigo_prestador"=>$data[1]));
                        $modelTipoServicio= TipoServicio::model()->findByAttributes(array("codigo_servicio"=>$data[2]));
                        $modelGrse= Grse::model()->findByAttributes(array("id_grse"=>$data[3]));
                        if(empty($modelPrestador->id_prestador)){throw new Exception("1");}else{$data[1]=$modelPrestador->id_prestador;}
                        if(empty($modelTipoServicio->id_tiposervicio)){throw new Exception("2");}else{$data[2]=$modelTipoServicio->id_tiposervicio;}
                        if(empty($modelGrse->id_grse)){throw new Exception("3");}else{$data[3]=$modelGrse->id_grse;}
                        if(empty($data[4])){$data[4]="NO REGISTRA";}
                        if(empty($data[5])){$data[5]="NO REGISTRA";}
                        if(empty($data[6])){$data[6]="NO REGISTRA";}
                        if(empty($data[7])){$data[7]="NO REGISTRA";}
                        if(empty($data[8])){$data[8]="NO REGISTRA";}
                        if(empty($data[9])){$data[9]="NO REGISTRA";}
                        if(empty($data[10])){$data[10]="NO REGISTRA";}
                        if(empty($data[11])){$data[11]="NO REGISTRA";}
                        if(empty($data[12])){$data[12]="NO REGISTRA";}
                        if(empty($data[13])){$data[13]="NO REGISTRA";}
                        if(empty($data[14])){$data[14]="NO REGISTRA";}
                        if(empty($data[15])){$data[15]="NO REGISTRA";}
                        if(empty($data[16])){$data[16]="NO REGISTRA";}
                        if(empty($data[17])){$data[17]="NO REGISTRA";}
                        if(empty($data[18]) || $data[18]==0){$data[18]=null;}
                        if(empty($data[19]) || $data[19]==0){$data[19]=null;}
                        if(empty($data[20])){$data[20]="NO REGISTRA";}
                        if(!is_numeric($data[21])){$data[21]=0;}
                        if(empty($data[22])){$data[22]="NO REGISTRA";}
                        $idServicio=$modelTipoServicio->id_tiposervicio;
                        $query->bindParam(":id_prestador",$data[1]);
                        $query->bindParam(":id_tiposervicio",$idServicio);
                        $query->bindParam(":id_grse",$data[3]);
                        $query->bindParam(":ese",$data[4]);
                        $query->bindParam(":nivel",$data[5]);
                        $query->bindParam(":caracter",$data[6]);
                        $query->bindParam(":habilitado",$data[7]);
                        $query->bindParam(":ambulatorio",$data[8]);
                        $query->bindParam(":hospitalario",$data[9]);
                        $query->bindParam(":unidad_movil",$data[10]);
                        $query->bindParam(":domiciliario",$data[11]);
                        $query->bindParam(":otrase_extramural",$data[12]);
                        $query->bindParam(":centro_referencia",$data[13]);
                        $query->bindParam(":institucion_remisora",$data[14]);
                        $query->bindParam(":complejidad_baja",$data[15]);
                        $query->bindParam(":complejidad_media",$data[16]);
                        $query->bindParam(":complejidad_alta",$data[17]);
                        $query->bindParam(":fecha_apertura",$data[18]);
                        $query->bindParam(":fecha_cierre",$data[19]);
                        $query->bindParam(":numero_distintivo",$data[20]);
                        $query->bindParam(":numero_sede_principal",$data[21]);
                        $query->bindParam(":fecha_corte_resp",$data[22]);
                        
                        if(!$query->execute()){
                            throw new Exception("Error general");
                        }
                        
                        
                    }
                    catch(Exception $e){
                        $registro=$pk+1;
                        $varSalida.="No se cargó el registro No. ".$pk." error en el campo No. ".$e->getMessage();
                        $varSalida.="\n---------------------\n";
                    }
//                }
            }
        }
        return $varSalida;
    }
    public function loadCapacidadInstalada($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO capacidad_instalada (id_grupocap,id_modalidad,id_prestador,id_coca,cantidad_capinstalada,modelo,habilitado_ca) VALUES (:id_grupocap,:id_modalidad,:id_prestador,:id_coca,:cantidad_capinstalada,:modelo,:habilitado_ca)";
        $numRows= count($data->sheets[0]['cells']);
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        $varSalida="";
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                try{    
                    $modelGrupoCapacidad= GrupoCapacidad::model()->findByAttributes(array("id_grupocap"=>$data[1]));
                    if(empty($modelGrupoCapacidad->id_grupocap)){throw new Exception("1");}
                    if(!empty($data[2]) && $data[2]!=""){
                        $modelModalidad= Modalidad::model()->findByAttributes(array("id_modalidad"=>$data[2]));
                        if(empty($modelModalidad->id_modalidad)){throw new Exception("2");}
                    }
                    else{
                        $data[2]=null;
                    }
                    $modelPrestador= Prestador::model()->findByAttributes(array("codigo_prestador"=>$data[3]));
                    if(empty($modelPrestador->id_prestador)){throw new Exception("3");}else{$data[3]=$modelPrestador->id_prestador;}
                    $modelCocaNombre= CocaNombre::model()->findByAttributes(array("id_coca"=>$data[4]));
                    if(empty($modelCocaNombre->id_coca)){throw new Exception("4");}
                    $query->bindParam(":id_grupocap",$data[1]);
                    $query->bindParam(":id_modalidad",$data[2]);
                    $query->bindParam(":id_prestador",$data[3]);
                    $query->bindParam(":id_coca",$data[4]);
                    $query->bindParam(":cantidad_capinstalada",$data[5]);
                    $query->bindParam(":modelo",$data[6]);
                    $query->bindParam(":habilitado_ca",$data[7]);
                    $query->execute(); 
                }
                catch(Exception $e){
                    $registro=$pk+1;
                    $varSalida.="No se cargó el registro No. ".$pk." error en el campo No. ".$e->getMessage();
                    $varSalida.="\n---------------------\n";
                }
            }
        }
        return $varSalida;
    }
    
    public function loadAfiliacion($dir,$filename,$tablename){
        ini_set('max_execution_time', 0);
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO afiliacion (id_tipoafiliado,id_genero,id_admin,id_quinquenio,id_tipopoblacion,id_zona,id_regimenadmon,anio_afiliacion,mes_afiliacion,total_poblacion,id_municipio) "
                . "VALUES (:id_tipoafiliado,:id_genero,:id_admin,:id_quinquenio,:id_tipopoblacion,:id_zona,:id_regimenadmon,:anio_afiliacion,:mes_afiliacion,:total_poblacion,:id_municipio)";
        $numRows= count($data->sheets[0]['cells']);
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        $varSalida="";
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                try{
                    $modelTipoAfiliado= TipoAfiliado::model()->findByAttributes(array("id_tipoafiliado"=>$data[1]));
                    $modelGenero= Genero::model()->findByAttributes(array("id_genero"=>$data[2]));
                    $modelAdministrador= Administrador::model()->findByAttributes(array("codigo_eps"=>$data[3]));
                    $modelTipoPoblacion= TipoPoblacion::model()->findByAttributes(array("id_tipopoblacion"=>$data[5]));
                    $modelRegimenAdministrador= RegimenAdministrador::model()->findByAttributes(array("id_regimenadmon"=>$data[7]));
                    $modelQuinquenio= Quinquenio::model()->findByAttributes(array("id_quinquenio"=>$data[4]));
                    $modelZona= Zona::model()->findByAttributes(array("id_zona"=>$data[6]));
                    $modelMunicipio= Municipio::model()->findByAttributes(array("idvar_municipio"=>$data[11]));
                    if(empty($modelTipoAfiliado->id_tipoafiliado)){throw new Exception("1");}else{$data[1]=$modelTipoAfiliado->id_tipoafiliado;}
                    if(empty($modelGenero->id_genero)){throw new Exception("2");}else{$data[2]=$modelGenero->id_genero;}
                    if(empty($modelAdministrador->id_admin)){throw new Exception("3");}else{$data[3]=$modelAdministrador->id_admin;}
                    if(empty($modelTipoPoblacion->id_tipopoblacion)){throw new Exception("5");}else{$data[5]=$modelTipoPoblacion->id_tipopoblacion;}
                    if(empty($modelRegimenAdministrador->id_regimenadmon)){throw new Exception("7");}else{$data[7]=$modelRegimenAdministrador->id_regimenadmon;}
                    if(empty($modelQuinquenio->id_quinquenio)){throw new Exception("4");}
                    if(empty($modelZona->id_zona)){throw new Exception("6");}
                    if(empty($modelMunicipio->id_municipio)){throw new Exception("11");}else{$data[11]=$modelMunicipio->id_municipio;}
                    $modelMes= Mes::model()->findByAttributes(array("nombre_mes"=>$data[9]));
                    $data[9]=$modelMes->id_mes;
                    $query->bindParam(":id_tipoafiliado",$data[1]);
                    $query->bindParam(":id_genero",$data[2]);
                    $query->bindParam(":id_admin",$data[3]);
                    $query->bindParam(":id_quinquenio",$data[4]);
                    $query->bindParam(":id_tipopoblacion",$data[5]);
                    $query->bindParam(":id_zona",$data[6]);
                    $query->bindParam(":id_regimenadmon",$data[7]);
                    $query->bindParam(":anio_afiliacion",$data[8]);
                    $query->bindParam(":mes_afiliacion",$data[9]);
                    $query->bindParam(":total_poblacion",$data[10]);
                    $query->bindParam(":id_municipio",$data[11]);
                    $query->execute(); 
                }
                catch(Exception $e){
                    $registro=$pk+1;
                    $varSalida.="No se cargó el registro No. ".$pk." error en el campo No. ".$e->getMessage();
                    $varSalida.="\n---------------------\n";
                }
            }
        }
        return $varSalida;
    }
    public function loadMunicipio($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO municipio (idvar_municipio,id_departamento,nombre_municipio) VALUES (:idvar_municipio,:id_departamento,:nombre_municipio)";
        $numRows= count($data->sheets[0]['cells']);
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $modelMunicipio= Municipio::model()->findByAttributes(array("idvar_municipio"=>$data[1]));
                if(empty($modelMunicipio) || !is_object($modelMunicipio)){
                    $modelDepartamento=Departamento::model()->findByAttributes(array("idvar_departamento"=>$data[2]));
                    if(!empty($modelDepartamento) && is_object($modelDepartamento)){
                        $idDepartamento=$modelDepartamento->id_departamento;
                        $query->bindParam(":idvar_municipio",$data[1]);
                        $query->bindParam(":id_departamento",$idDepartamento);
                        $query->bindValue(":nombre_municipio",utf8_encode($data[3]));
                        $query->execute(); 
                    }
                }
            }
        }
    }
    public function loadOferente($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sqlIns="INSERT INTO oferente (id_municipio,nit_oferente,codver_oferente,razon_social_oferente,direccion_oferente,telefono_oferente) VALUES (:id_municipio,:nit_oferente,:codver_oferente,:razon_social_oferente,:direccion_oferente,:telefono_oferente)";
        $numRows= count($data->sheets[0]['cells']);
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sqlIns);
        $noCargados=array();
        $varSalida="";
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $modelOferente= Oferente::model()->findByAttributes(array("nit_oferente"=>$data[3]));
                if(empty($modelOferente) || !is_object($modelOferente)){
                    $modelMunicipio= Municipio::model()->findByAttributes(array('idvar_municipio'=>$data[2]));
                    if(empty($modelMunicipio)){
                        $data[2]='0'.$data[2];
                        $modelMunicipio= Municipio::model()->findByAttributes(array('idvar_municipio'=>$data[2]));
                    }
                    try{
                        if(empty($modelMunicipio) && !is_object($modelMunicipio)){throw new Exception("2");}else{$data[2]=$modelMunicipio->id_municipio;}                        
                        (empty($data[2]))?$data[2]=null:"";
                        (empty($data[3]))?$data[3]=null:$data[3]=utf8_encode($data[3]);
                        (empty($data[4]))?$data[4]=null:"";
                        (empty($data[5]))?$data[5]=null:$data[5]=utf8_encode($data[5]);
                        (empty($data[6]))?$data[6]=null:$data[6]=utf8_encode($data[6]);
                        (empty($data[7]))?$data[7]=null:$data[7]=utf8_encode($data[7]);
                        $query->bindParam(":id_municipio",$data[2]);
                        $query->bindParam(":nit_oferente",$data[3]);
                        $query->bindParam(":codver_oferente",$data[4]);
                        $query->bindParam(":razon_social_oferente",$data[5]);
                        $query->bindParam(":direccion_oferente",$data[6]);
                        $query->bindParam(":telefono_oferente",$data[7]);
                        $query->execute(); 
                    }
                     catch(Exception $e){
                        $registro=$pk+1;
                        $varSalida.="No se cargó el registro No. ".$pk." error en el campo No. ".$e->getMessage();
                        $varSalida.="\n---------------------\n";
                    }
                }
                else{
                    (empty($data[5]))?$data[5]=null:$data[5]=utf8_encode($data[5]);
                    $razonSocBd=$modelOferente->razon_social_oferente;
                    $razonSocFile=$data[5];
                    $cambio=$this->cambiosLevensthein($razonSocFile, $razonSocBd);
                    if($cambio){
                        $idOferente=$modelOferente->id_oferente;
                        $sqlUpd="UPDATE oferente set razon_social_oferente=:razon_social_oferente where nit_oferente=:nit_oferente";
                        $queryUpd=$conn->createCommand($sqlUpd);
                        $queryUpd->bindParam(":razon_social_oferente",$data[5]);
                        $queryUpd->bindParam(":nit_oferente",$data[3]);
                        $queryUpd->execute(); 
                        $sqlInsert="INSERT INTO historico_oferente (id_oferente,h_razon_social,h_direccion,h_telefono) VALUES (:id_oferente,:h_razon_social,:h_direccion,:h_telefono)";
                        $queriIns=$conn->createCommand($sqlInsert);
                        $queriIns->bindParam(":id_oferente",$idOferente);
                        $queriIns->bindParam(":h_razon_social",$data[5]);
                        $queriIns->bindParam(":h_direccion",$data[6]);
                        $queriIns->bindParam(":h_telefono",$data[7]);
                        $queriIns->execute();
                    }
                }
            }
        }
        return $varSalida;
    }
    public function cambiosLevensthein($strni,$strii){
        $lev = levenshtein($strni, $strii);
        $numPal=strlen($strii);
        $porc=$lev*100/$numPal;
        if($porc>=30){
            return true;
        }
        else{
            return false;
        }
    }
    public function loadImportacionDian($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        set_time_limit(-1);
        $columns=$this->getColumns();
        $refColumns=$this->getRefColumns();
        $sql="INSERT INTO importacion_dian (".$columns.") ";
        $sql.= "VALUES (".$refColumns.")";
        $numRows= count($data->sheets[0]['cells']);
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        $varSalida="";
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $data[2]=(int)$data[2];
                $modelImportacionDian= ImportacionDian::model()->findByAttributes(array("c132"=>$data[111]));
                if(empty($modelImportacionDian) || !is_object($modelImportacionDian)){
                    try{
                        $modelOferente=Oferente::model()->findByAttributes(array("nit_oferente"=>$data[2]));
                        if(empty($modelOferente)){throw new Exception("2");}else{$data[2]=$modelOferente->id_oferente;}
                        for($in=2;$in<=117;$in++){
                           (empty($data[$in]))?$data[$in]=null:"";
                           (!empty($data[$in]))?$data[$in]=utf8_encode($data[$in]):"";
                        }
                        $modelMes= Mes::model()->findByAttributes(array("nombre_mes"=>$data[4]));
                        $data[4]=$modelMes->id_mes;
                        $query->bindParam(":id_oferente",$data[2]);
                        $query->bindParam(":anio_c1",$data[3]);
                        $query->bindParam(":mes_dian",$data[4]);
                        $query->bindParam(":numerod_de_formulario_c4",$data[5]);
                        $query->bindParam(":c24",$data[6]);
                        $query->bindParam(":c25",$data[7]);
                        $query->bindParam(":c26",$data[8]);
                        $query->bindParam(":c29",$data[9]);
                        $query->bindParam(":c30",$data[10]);
                        $query->bindParam(":c31",$data[11]);
                        $query->bindParam(":c32",$data[12]);
                        $query->bindParam(":c33",$data[13]);
                        $query->bindParam(":c34",$data[14]);
                        $query->bindParam(":c35",$data[15]);
                        $query->bindParam(":c36",$data[16]);
                        $query->bindParam(":c37",$data[17]);
                        $query->bindParam(":c38",$data[18]);
                        $query->bindParam(":c39",$data[19]);
                        $query->bindParam(":c40",$data[20]);
                        $query->bindParam(":c41",$data[21]);
                        $query->bindParam(":c42",$data[22]);
                        $query->bindParam(":c43",$data[23]);
                        $query->bindParam(":c44",$data[24]);
                        $query->bindParam(":c45",$data[25]);
                        $query->bindParam(":c46",$data[26]);
                        $query->bindParam(":c47",$data[27]);
                        $query->bindParam(":c48",$data[28]);
                        $query->bindParam(":c49",$data[29]);
                        $query->bindParam(":c50",$data[30]);
                        $query->bindParam(":c51",$data[31]);
                        $query->bindParam(":c52",$data[32]);
                        $query->bindParam(":c53",$data[33]);
                        $query->bindParam(":c54",$data[34]);
                        $query->bindParam(":c55",$data[35]);
                        $query->bindParam(":c56",$data[36]);
                        $query->bindParam(":c57",$data[37]);
                        $query->bindParam(":c58",$data[38]);
                        $query->bindParam(":c59",$data[39]);
                        $query->bindParam(":c60",$data[40]);
                        $query->bindParam(":c61",$data[41]);
                        $query->bindParam(":c62",$data[42]);
                        $query->bindParam(":c63",$data[43]);
                        $query->bindParam(":c64",$data[44]);
                        $query->bindParam(":c65",$data[45]);
                        $query->bindParam(":c66",$data[46]);
                        $query->bindParam(":c67",$data[47]);
                        $query->bindParam(":c68",$data[48]);
                        $query->bindParam(":c69",$data[49]);
                        $query->bindParam(":c70",$data[50]);
                        $query->bindParam(":c71",$data[51]);
                        $query->bindParam(":c72",$data[52]);
                        $query->bindParam(":c73",$data[53]);
                        $query->bindParam(":c74",$data[54]);
                        $query->bindParam(":c75",$data[55]);
                        $query->bindParam(":c76",$data[56]);
                        $query->bindParam(":c77",$data[57]);
                        $query->bindParam(":c78",$data[58]);
                        $query->bindParam(":c79",$data[59]);
                        $query->bindParam(":c80",$data[60]);
                        $query->bindParam(":c81",$data[61]);
                        $query->bindParam(":c82",$data[62]);
                        $query->bindParam(":c83",$data[63]);
                        $query->bindParam(":c84",$data[64]);
                        $query->bindParam(":c85",$data[65]);
                        $query->bindParam(":c86",$data[66]);
                        $query->bindParam(":c87",$data[67]);
                        $query->bindParam(":c88",$data[68]);
                        $query->bindParam(":c89",$data[69]);
                        $query->bindParam(":c90",$data[70]);
                        $query->bindParam(":c92",$data[71]);
                        $query->bindParam(":c93",$data[72]);
                        $query->bindParam(":c94",$data[73]);
                        $query->bindParam(":c95",$data[74]);
                        $query->bindParam(":c96",$data[75]);
                        $query->bindParam(":c97",$data[76]);
                        $query->bindParam(":c98",$data[77]);
                        $query->bindParam(":c99",$data[78]);
                        $query->bindParam(":c100",$data[79]);
                        $query->bindParam(":c101",$data[80]);
                        $query->bindParam(":c102",$data[81]);
                        $query->bindParam(":c103",$data[82]);
                        $query->bindParam(":c104",$data[83]);
                        $query->bindParam(":c105",$data[84]);
                        $query->bindParam(":c106",$data[85]);
                        $query->bindParam(":c107",$data[86]);
                        $query->bindParam(":c108",$data[87]);
                        $query->bindParam(":c109",$data[88]);
                        $query->bindParam(":c110",$data[89]);
                        $query->bindParam(":c111",$data[90]);
                        $query->bindParam(":c112",$data[91]);
                        $query->bindParam(":c113",$data[92]);
                        $query->bindParam(":c114",$data[93]);
                        $query->bindParam(":c115",$data[94]);
                        $query->bindParam(":c116",$data[95]);
                        $query->bindParam(":c117",$data[96]);
                        $query->bindParam(":c118",$data[97]);
                        $query->bindParam(":c119",$data[98]);
                        $query->bindParam(":c120",$data[99]);
                        $query->bindParam(":c121",$data[100]);
                        $query->bindParam(":c122",$data[101]);
                        $query->bindParam(":c123",$data[102]);
                        $query->bindParam(":c124",$data[103]);
                        $query->bindParam(":c125",$data[104]);
                        $query->bindParam(":c126",$data[105]);
                        $query->bindParam(":c91",$data[106]);
                        $query->bindParam(":c127",$data[107]);
                        $query->bindParam(":c128",$data[108]);
                        $query->bindParam(":c129",$data[109]);
                        $query->bindParam(":c131",$data[110]);
                        $query->bindParam(":c132",$data[111]);
                        $query->bindParam(":c133",$data[112]);
                        $query->bindParam(":c134",$data[113]);
                        $query->bindParam(":c135",$data[114]);
                        $query->bindParam(":c980",$data[115]);
                        $query->bindParam(":c997",$data[116]);
                        $query->bindParam(":c996",$data[117]);
                        $query->execute(); 
                    }
                    catch(Exception $e){
                        $registro=$pk+1;
                        $varSalida.="No se cargó el registro No. ".$pk." error en el campo No. ".$e->getMessage();
                        $varSalida.="\n---------------------\n";
                    }
                }
            }
        }
        return $varSalida;
    }
    private function getColumns(){
        $columns="id_oferente,
anio_c1,
mes_dian,
numerod_de_formulario_c4,
c24,
c25,
c26,
c29,
c30,
c31,
c32,
c33,
c34,
c35,
c36,
c37,
c38,
c39,
c40,
c41,
c42,
c43,
c44,
c45,
c46,
c47,
c48,
c49,
c50,
c51,
c52,
c53,
c54,
c55,
c56,
c57,
c58,
c59,
c60,
c61,
c62,
c63,
c64,
c65,
c66,
c67,
c68,
c69,
c70,
c71,
c72,
c73,
c74,
c75,
c76,
c77,
c78,
c79,
c80,
c81,
c82,
c83,
c84,
c85,
c86,
c87,
c88,
c89,
c90,
c91,
c92,
c93,
c94,
c95,
c96,
c97,
c98,
c99,
c100,
c101,
c102,
c103,
c104,
c105,
c106,
c107,
c108,
c109,
c110,
c111,
c112,
c113,
c114,
c115,
c116,
c117,
c118,
c119,
c120,
c121,
c122,
c123,
c124,
c125,
c126,
c127,
c128,
c129,
c131,
c132,
c133,
c134,
c135,
c980,
c997,
c996
";
        return $columns;
    }
    private function getRefColumns(){
        $columns=":id_oferente,
:anio_c1,
:mes_dian,
:numerod_de_formulario_c4,
:c24,
:c25,
:c26,
:c29,
:c30,
:c31,
:c32,
:c33,
:c34,
:c35,
:c36,
:c37,
:c38,
:c39,
:c40,
:c41,
:c42,
:c43,
:c44,
:c45,
:c46,
:c47,
:c48,
:c49,
:c50,
:c51,
:c52,
:c53,
:c54,
:c55,
:c56,
:c57,
:c58,
:c59,
:c60,
:c61,
:c62,
:c63,
:c64,
:c65,
:c66,
:c67,
:c68,
:c69,
:c70,
:c71,
:c72,
:c73,
:c74,
:c75,
:c76,
:c77,
:c78,
:c79,
:c80,
:c81,
:c82,
:c83,
:c84,
:c85,
:c86,
:c87,
:c88,
:c89,
:c90,
:c91,
:c92,
:c93,
:c94,
:c95,
:c96,
:c97,
:c98,
:c99,
:c100,
:c101,
:c102,
:c103,
:c104,
:c105,
:c106,
:c107,
:c108,
:c109,
:c110,
:c111,
:c112,
:c113,
:c114,
:c115,
:c116,
:c117,
:c118,
:c119,
:c120,
:c121,
:c122,
:c123,
:c124,
:c125,
:c126,
:c127,
:c128,
:c129,
:c131,
:c132,
:c133,
:c134,
:c135,
:c980,
:c997,
:c996
";
        return $columns;
    }
    public function loadPrestador($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO prestador (id_claseprestador,id_nivelatencion,id_municipio,id_naturalezajuridica,codigo_prestador,nombre_prestador,direccion_prestador,telefono_prestador)"
                . " VALUES (:id_claseprestador,:id_nivelatencion,:id_municipio,:id_naturalezajuridica,:codigo_prestador,:nombre_prestador,:direccion_prestador,:telefono_prestador)";
				
        $numRows= count($data->sheets[0]['cells']);
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        $varSalida="";
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $modelPrestador= Prestador::model()->findByAttributes(array("codigo_prestador"=>$data[5]));
                if(empty($modelPrestador) || !is_object($modelPrestador)){
                    try{
    //                    $modelAdministrador=Administrador::model()->findByAttributes(array("nombre_admin"=>$data[1]));
                        $modelClasePrestador=ClasePrestador::model()->findByAttributes(array("id_claseprestador"=>$data[1]));
                        $modelNivelAtencion=NivelAtencion::model()->findByAttributes(array("id_nivelatencion"=>$data[2]));
                        $modelNaturalezaJuridica=NaturalezaJuridica::model()->findByAttributes(array("id_naturalezajuridica"=>$data[3]));                                     
                        $modelMunicipio=Municipio::model()->findByAttributes(array("idvar_municipio"=>$data[4]));
                        if(empty($modelClasePrestador)){throw new Exception("1");}
                        if(empty($modelNivelAtencion)){throw new Exception("2");}
                        if(empty($modelNaturalezaJuridica)){throw new Exception("3");}
                        if(empty($modelMunicipio)){throw new Exception("4");}  
//                        if(!empty($modelAdministrador) && !empty($modelMunicipio)){
                            $nombre= utf8_encode($data[6]);
    //                    print_r($modelMunicipio);echo "------------------";exit();
//                            (empty($data[3]))?$data[3]=null:$data[4]=utf8_encode($data[3]);
                            (empty($data[7]))?$data[7]=null:$data[7]=utf8_encode($data[7]);
                            (empty($data[8]))?$data[8]=null:$data[8]=utf8_encode($data[8]);
    //                        $data[1]=$modelAdministrador->id_admin;
                            $data[4]=$modelMunicipio->id_municipio;
    //                        $query->bindParam(":id_admin",$data[1]);
                            $query->bindParam(":id_claseprestador",$data[1]);
                            $query->bindParam(":id_nivelatencion",$data[2]);
                            $query->bindParam(":id_naturalezajuridica",$data[3]);
                            $query->bindParam(":id_municipio",$data[4]);
                            $query->bindParam(":codigo_prestador",$data[5]);
                            $query->bindParam(":nombre_prestador",$nombre);
                            $query->bindParam(":direccion_prestador",$data[7]);
                            $query->bindParam(":telefono_prestador",$data[8]);
                            $query->execute(); 
                    }
                    catch(Exception $e){
                        $registro=$pk+1;
                        $varSalida.="No se cargó el registro No. ".$pk." error en el campo No. ".$e->getMessage();
                        $varSalida.="\n---------------------\n";
                    }
    //                    }
                }
            }
        }
        return $varSalida;
    }
     public function loadProducto($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO producto (id_importaciondian,"
                . "id_categoriaproducto,"
                . "id_proveedor,"
                . "id_marca,"
                . "nombre_producto,"
                . "modelo_producto,"
                . "referencia_producto,"
                . "uso_destino,"
                . "serial_producto,"
                . "cantidad_presentacion,"
                . "unidad_presentacion,"
                . "cantidad,"
                . "presentacion,"
                . "registro_invima,"
                . "descripcion_producto,"
                . "pais_origen,"
                . "precio_unidad_cop,"
                . "precio_total_cop,"
                . "precio_total_usd,"
                . "precio_formulario_usd,"
                . "porcentaje_del_total,"
                . "precio_estimado_usd,"
                . "precio_estimado_unitario,"
                . "incluir)"
                . " VALUES (:id_importaciondian,"
                . ":id_categoriaproducto,"
                . ":id_proveedor,"
                . ":id_marca,"
                . ":nombre_producto,"
                . ":modelo_producto,"
                . ":referencia_producto,"
                . ":uso_destino,"
                . ":serial_producto,"
                . ":cantidad_presentacion,"
                . ":unidad_presentacion,"
                . ":cantidad,"
                . ":presentacion,"
                . ":registro_invima,"
                . ":descripcion_producto,"
                . ":pais_origen,"
                . ":precio_unidad_cop,"
                . ":precio_total_cop,"
                . ":precio_total_usd,"
                . ":precio_formulario_usd,"
                . ":porcentaje_del_total,"
                . ":precio_estimado_usd,"
                . ":precio_estimado_unitario,"
                . ":incluir)";
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        $varSalida="";
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
//                $modelImportacionDian= ImportacionDian::model()->findByAttributes(array("c132"=>$data[1]));
//                if(!empty($modelImportacionDian) && !empty($modelImportacionDian)){
//                    $data[1]=$modelImportacionDian->id_importaciondian;
                    try{
                        $modelImportacionDian= ImportacionDian::model()->findByAttributes(array("c132"=>$data[1]));
                        ($data[2]!='S.I')?$modelCategoriaProducto= CategoriaProducto::model()->findByAttributes(array("id_categoriaproducto"=>$data[2])):$data[2]=null;
                        ($data[3]!='S.I')?$modelProveedor= Proveedor::model()->findByAttributes(array("id_proveedor"=>$data[3])):$data[3]=null;
                        ($data[4]!='S.I')?$modelMarca=Marca::model()->findByAttributes(array("id_marca"=>$data[4])):$data[4]=null;
                        if(empty($modelImportacionDian)){throw new Exception("1");}else{$data[1]=$modelImportacionDian->id_importaciondian;}
                        if($data[2]!=null && empty($modelCategoriaProducto->id_categoriaproducto)){throw new Exception("2");}
                        if($data[3]!=null && empty($modelProveedor->id_proveedor)){throw new Exception("3");}
                        if($data[4]!=null &&empty($modelMarca)){throw new Exception("4");}
                        (empty($data[5]))?$data[5]=null:$data[5]=utf8_encode($data[5]);
                        (empty($data[6]))?$data[6]=null:$data[6]=utf8_encode($data[6]);
                        (empty($data[7]))?$data[7]=null:$data[7]=utf8_encode($data[7]);
                        (empty($data[8]))?$data[8]=null:$data[8]=utf8_encode($data[8]);
                        (empty($data[9]))?$data[9]=null:$data[9]=utf8_encode($data[9]);
                        (empty($data[10]))?$data[10]=null:$data[10]=utf8_encode($data[10]);
                        (empty($data[11]))?$data[11]=null:$data[11]=utf8_encode($data[11]);
                        (empty($data[12]))?$data[12]=null:$data[12]=utf8_encode($data[12]);
                        (empty($data[13]))?$data[13]=null:$data[13]=utf8_encode($data[13]);
                        (empty($data[14]))?$data[14]=null:$data[14]=utf8_encode($data[14]);
                        (empty($data[15]))?$data[15]=null:$data[15]=utf8_encode($data[15]);
                        (empty($data[16]))?$data[16]=null:$data[16]=utf8_encode($data[16]);
                        (empty($data[17]))?$data[17]=null:$data[17]=utf8_encode($data[17]);
                        (empty($data[17]))?$data[18]=null:$data[18]=utf8_encode($data[18]);
                        (empty($data[17]))?$data[19]=null:$data[19]=utf8_encode($data[19]);
                        (empty($data[17]))?$data[20]=null:$data[20]=utf8_encode($data[20]);
                        (empty($data[17]))?$data[21]=null:$data[21]=utf8_encode($data[21]);
                        (empty($data[17]))?$data[22]=null:$data[22]=utf8_encode($data[22]);
                        (empty($data[17]))?$data[23]=null:$data[23]=utf8_encode($data[23]);
                        (empty($data[17]))?$data[24]=null:$data[24]=utf8_encode($data[24]);
                        $query->bindParam(":id_importaciondian",$data[1]);
                        $query->bindParam(":id_categoriaproducto",$data[2]);
                        $query->bindParam(":id_proveedor",$data[3]);
                        $query->bindParam(":id_marca",$data[4]);
                        $query->bindParam(":nombre_producto",$data[5]);
                        $query->bindParam(":modelo_producto",$data[6]);
                        $query->bindParam(":referencia_producto",$data[7]);
                        $query->bindParam(":uso_destino",$data[8]);
                        $query->bindParam(":serial_producto",$data[9]);
                        $query->bindParam(":cantidad_presentacion",$data[10]);
                        $query->bindParam(":unidad_presentacion",$data[11]);
                        $query->bindParam(":cantidad",$data[12]);
                        $query->bindParam(":presentacion",$data[13]);
                        $query->bindParam(":registro_invima",$data[14]);
                        $query->bindParam(":descripcion_producto",$data[15]);
                        $query->bindParam(":pais_origen",$data[16]);
                        $query->bindParam(":precio_unidad_cop",$data[17]);
                        $query->bindParam(":precio_total_cop",$data[18]);
                        $query->bindParam(":precio_total_usd",$data[19]);
                        $query->bindParam(":precio_formulario_usd",$data[20]);
                        $query->bindParam(":porcentaje_del_total",$data[21]);
                        $query->bindParam(":precio_estimado_usd",$data[22]);
                        $query->bindParam(":precio_estimado_unitario",$data[23]);
                        $query->bindParam(":incluir",$data[24]);
                        $query->execute(); 
                    }
                    catch(Exception $e){
                        $registro=$pk+1;
                        $varSalida.="No se cargó el registro No. ".$pk." error en el campo No. ".$e->getMessage();
                        $varSalida.="\n---------------------\n";
                    }
//                }
            }
        }
        return $varSalida;
    }
    public function loadProcedimiento($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO procedimiento (idvar_procedimiento,id_categoria,nombre_procedimiento) VALUES (:idvar_procedimiento,:id_categoria,:nombre_procedimiento)";
        $numRows= count($data->sheets[0]['cells']);
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        $varSalida="";
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $modeloProcedimiento= Procedimiento::model()->findByAttributes(array("idvar_procedimiento"=>$data[1]));
                if(empty($modeloProcedimiento) || !is_object($modeloProcedimiento)){
                    try{
                        $modeloCategoria= Categoria::model()->findByAttributes(array("idvar_categoria"=>$data[2]));
                        if(empty($modeloCategoria)){throw new Exception("2");}else{$data[2]=$modeloCategoria->id_categoria;}
                        (empty($data[3]))?$data[3]="":$data[3]=utf8_encode($data[3]);
                        (empty($data[4]))?$data[4]=null:"";
                        $query->bindParam(":idvar_procedimiento",$data[1]);
                        $query->bindParam(":id_categoria",$data[2]);
                        $query->bindParam(":nombre_procedimiento",$data[3]);
                        $query->execute(); 
                    }
                    catch(Exception $e){
                        $registro=$pk+1;
                        $varSalida.="No se cargó el registro No. ".$pk." error en el campo No. ".$e->getMessage();
                        $varSalida.="\n---------------------\n";
                    }
                    
                }
            }
        }
        return $varSalida;
    }
    public function loadProcedimientoPrestador($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO procedimiento_prestador (id_prestador,id_procedimiento,id_quinquenio,id_tipousuario,id_grupopoblacional,mes,anio,numero_atenciones,numero_personas_atendidas,costo_procedimiento) VALUES (:id_prestador,:id_procedimiento,:id_quinquenio,:id_tipousuario,:id_grupopoblacional,:mes,:anio,:numero_atenciones,:numero_personas_atendidas,:costo_procedimiento)";
        $numRows= count($data->sheets[0]['cells']);
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        $varSalida="";
        ini_set('max_execution_time', 0);
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
//               $data[3]= trim($data[3]);
//               $codPrestador=explode(" - ",utf8_encode($data[1]));
                $modeloPrestador= Prestador::model()->findByAttributes(array("codigo_prestador"=>$data[1]));
                $modeloProcedimiento= Procedimiento::model()->findByAttributes(array("idvar_procedimiento"=>$data[2]));
//                echo utf8_encode($data[5]);exit();
                $modeloQuinquenio= Quinquenio::model()->findByAttributes(array("id_quinquenio"=>$data[3]));
                $modeloTipoUsuario= TipoUsuario::model()->findByAttributes(array("id_tipousuario"=>$data[4]));
//                $modeloTipoAtencion= TipoAtencion::model()->findByAttributes(array("id_tipoatencion"=>$data[5]));
                $modelGrupoPoblacional= GrupoPoblacional::model()->findByAttributes(array("id_grupopoblacional"=>$data[7]));
                try{
                    if(empty($modeloPrestador->id_prestador)){throw new Exception("1");}else{$data[1]=$modeloPrestador->id_prestador;}
                    if(empty($modeloProcedimiento->id_procedimiento)){throw new Exception("2");}else{$data[2]=$modeloProcedimiento->id_procedimiento;}
                    if(empty($modeloQuinquenio->id_quinquenio)){throw new Exception("3");}else{$data[3]=$modeloQuinquenio->id_quinquenio;}
                    if(empty($modeloTipoUsuario->id_tipousuario)){throw new Exception("4");}else{$data[4]=$modeloTipoUsuario->id_tipousuario;}
//                    if(empty($modeloTipoAtencion->id_tipoatencion)){throw new Exception("5");}else{$data[5]=$modeloTipoAtencion->id_tipoatencion;}
                    if(empty($modelGrupoPoblacional->id_grupopoblacional)){throw new Exception("7");}
                    $modelMes= Mes::model()->findByAttributes(array("nombre_mes"=>$data[5]));
                    $data[5]=$modelMes->id_mes;
                    (empty($data[7]))?$data[6]=null:"";
                    (empty($data[8]))?$data[7]=null:"";
                    (empty($data[9]))?$data[8]=null:"";
                    (empty($data[10]))?$data[10]=null:"";
                    $query->bindParam(":id_prestador",$data[1]);
                    $query->bindParam(":id_procedimiento",$data[2]);
                    $query->bindParam(":id_quinquenio",$data[3]);
                    $query->bindParam(":id_tipousuario",$data[4]);
                    $query->bindParam(":mes",$data[5]);
                    $query->bindParam(":anio",$data[6]);
                    $query->bindParam(":id_grupopoblacional",$data[7]);
                    $query->bindParam(":numero_atenciones",$data[8]);
                    $query->bindParam(":numero_personas_atendidas",$data[9]);
                    $query->bindParam(":costo_procedimiento",$data[10]);
                    $query->execute(); 
//                    try{
//                        $query->execute(); 
//                    }
//                    catch(Exception $e){
//                        $e->getMessage();
//                    }
                }
                catch(Exception $e){
                    $registro=$pk+1;
                    $varSalida.="No se cargó el registro No. ".$pk." error en el campo No. ".$e->getMessage();
                    $varSalida.="\n---------------------\n";
                }
            }
        }
        return $varSalida;
    }
    public function searchProcedimiento(){
            // initilize all variable
            $params = $columns = $sqlRC = $data = array();
            $params = $_REQUEST;
            print_r($params);exit();
            //define index of column
            $params['search']['value']= mb_strtoupper($params['search']['value']);
            $columns = array( 
                0=>'tipo_atencion',
                1 =>'anio',
                2 =>'mes', 
                3 => 'nombre_municipio',
                4 => 'nombre_prestador',
                5 =>'nombre_grupo',
                6 =>'nombre_subgrupo', 
                7 => 'nombre_procedimiento',
                8 => 'nombre_admin',
                9=>'tipo_usuario',
                10=>'tipo_quinquenio',
                11=>'cantidad_atendida',
            );
            $columnsi = array(
                array( 'db' => 'tipo_atencion', 'dt' => "tipo_atencion" ),
                array( 'db' => 'anio',  'dt' => 'anio' ),
                array( 'db' => 'mes',   'dt' => 'mes' ),
                array( 'db' => 'nombre_municipio',     'dt' => 'nombre_municipio' ),
                array( 'db' => 'nombre_prestador',     'dt' => 'nombre_prestador' ),
                array( 'db' => 'nombre_grupo',     'dt' => 'nombre_grupo'),
                array( 'db' => 'nombre_subgrupo',     'dt' => 'nombre_subgrupo' ),
                array( 'db' => 'nombre_procedimiento',     'dt' => 'nombre_procedimiento' ),
                array( 'db' => 'nombre_admin',     'dt' => 'nombre_admin' ),
                array( 'db' => 'tipo_usuario',     'dt' => 'tipo_usuario' ),
                array( 'db' => 'tipo_quinquenio',     'dt' => 'tipo_quinquenio' ),
                array( 'db' => 'cantidad_atendida',     'dt' => 'cantidad_atendida' ),
            );
            $where = $sqlTot = $sqlRec = "";
            // check search value exist
            if( !empty($params['search']['value']) ) {   
                $where .=" WHERE ";
                $where .=" ( ta.tipo_atencion LIKE '".$params['search']['value']."%' ";
                if(filter_var($params['search']['value'], FILTER_VALIDATE_INT)){
                    $where .=" OR pp.anio = ".$params['search']['value'];
                }
                $where .=" OR pp.mes LIKE '".$params['search']['value']."%' ";
                $where .=" OR mn.nombre_municipio LIKE '".$params['search']['value']."%' ";
                $where .=" OR p.nombre_prestador LIKE '".$params['search']['value']."%' ";
                $where .=" OR gr.nombre_grupo LIKE '".$params['search']['value']."%' ";
                $where .=" OR sg.nombre_subgrupo LIKE '".$params['search']['value']."%' ";
                $where .=" OR pr.nombre_procedimiento LIKE '%".$params['search']['value']."%' ";
                $where .=" OR ad.nombre_admin LIKE '%".$params['search']['value']."%' ";
                $where .=" OR tu.tipo_usuario LIKE '".$params['search']['value']."%' ";
                $where .=" OR qn.tipo_quinquenio LIKE '".$params['search']['value']."%' ";
                if(is_int($params['search']['value'] || ctype_digit($params['search']['value']))){
                    $where .=" OR pp.cantidad_atendida = ".$params['search']['value'];
                }
                $where .=")";
            }

            // getting total number records without any search
            $connect=Yii::app()->db;
            $sql="select ta.tipo_atencion,pp.anio,pp.mes,mn.nombre_municipio,p.nombre_prestador,gr.nombre_grupo,sg.nombre_subgrupo,pr.nombre_procedimiento,ad.nombre_admin,tu.tipo_usuario,qn.tipo_quinquenio,pp.cantidad_atendida "
            ."from procedimiento_prestador as pp "
            ."left join prestador as p on p.id_prestador=pp.id_prestador "
            ."left join municipio as mn on mn.id_municipio=p.id_municipio "
            ."left join procedimiento as pr on pr.id_procedimiento=pp.id_procedimiento "
            ."left join categoria as ct on ct.id_categoria=pr.id_categoria "
            ."left join subgrupo as sg on sg.id_subgrupo=ct.id_subgrupo "
            ."left join grupo as gr on gr.id_grupo=sg.id_grupo "
            ."left join quinquenio as qn on qn.id_quinquenio=pp.id_quinquenio "
            ."left join tipo_usuario as tu on tu.id_tipousuario=pp.id_tipousuario "
            ."left join tipo_atencion as ta on ta.id_tipoatencion=pp.id_tipoatencion "
            ."left join administrador as ad on ad.id_admin=p.id_admin";
            
            $sqlTot .= $sql;
            $sqlRec .= $sql;
            //concatenate search sql if value exist
            if(isset($where) && $where != '') {
                $sqlTot .= $where;
                $sqlRec .= $where;
            }
            
            $sqlRec .=  " ORDER BY ". $columns[$params['order'][0]['column']]."   ".$params['order'][0]['dir']."  OFFSET ".$params['start']." LIMIT ".$params['length']." ";
            $query=$connect->createCommand($sqlRec);
            $read=$query->query();
            $results=$read->readAll();
            $read->close();
            
            /*total rows*/
            $sqlRC = "select ta.tipo_atencion,pp.anio,pp.mes,mn.nombre_municipio,p.nombre_prestador,gr.nombre_grupo,sg.nombre_subgrupo,pr.nombre_procedimiento,ad.nombre_admin,tu.tipo_usuario,qn.tipo_quinquenio,pp.cantidad_atendida "
            ."from procedimiento_prestador as pp "
            ."left join prestador as p on p.id_prestador=pp.id_prestador "
            ."left join municipio as mn on mn.id_municipio=p.id_municipio "
            ."left join procedimiento as pr on pr.id_procedimiento=pp.id_procedimiento "
            ."left join categoria as ct on ct.id_categoria=pr.id_categoria "
            ."left join subgrupo as sg on sg.id_subgrupo=ct.id_subgrupo "
            ."left join grupo as gr on gr.id_grupo=sg.id_grupo "
            ."left join quinquenio as qn on qn.id_quinquenio=pp.id_quinquenio "
            ."left join tipo_usuario as tu on tu.id_tipousuario=pp.id_tipousuario "
            ."left join tipo_atencion as ta on ta.id_tipoatencion=pp.id_tipoatencion "
            ."left join administrador as ad on ad.id_admin=p.id_admin ";
            $queryNR=$connect->createCommand($sqlRC);
            $readNR=$queryNR->query();
            $resultsNC=$readNR->rowCount;
            $readNR->close();
            
            
            
            foreach($results as $pk=>$result){
                $dataResult[0]=$result["tipo_atencion"];
                $dataResult[1]=$result["anio"];
                $dataResult[2]=$result["mes"];
                $dataResult[3]=$result["nombre_municipio"];
                $dataResult[4]=$result["nombre_prestador"];
                $dataResult[5]=$result["nombre_grupo"];
                $dataResult[6]=$result["nombre_subgrupo"];
                $dataResult[7]=$result["nombre_procedimiento"];
                $dataResult[8]=$result["nombre_admin"];
                $dataResult[9]=$result["tipo_usuario"];
                $dataResult[10]=$result["tipo_quinquenio"];
                $dataResult[11]=$result["cantidad_atendida"];
                $data[$pk]=$dataResult;
            }

            $json_data = array(
                "draw"            => intval( $params['draw'] ),   
                "recordsTotal"    => intval( $resultsNC ),  
                "recordsFiltered" => intval($resultsNC),
                "data"            => $data,
                "columns"=>$columnsi// total data array
            );
        
            return $json_data;
        
        
    }
    public function searchInfoPTables($nameTable,$columnNames){
            // initilize all variable
            $params = $columns = $sqlRC = $data = array();
            $params = $_REQUEST;
            //define index of column
            $params['search']['value']= mb_strtoupper($params['search']['value']);
            $i=0;
            foreach($columnNames as $pk=>$column){
                $columns[$i]=$column["column_name"];
                $i++;
            }
            $where = $sqlTot = $sqlRec = "";
            // check search value exist
            if( !empty($params['search']['value']) ) {   
                $where .=" WHERE (";
                foreach($columnNames as $pk=>$column){
                    if($column["data_type"]=="integer" || $column["data_type"]=="numeric" && is_int((int)$params['search']['value']) || ctype_digit((int)$params['search']['value'])){
                        $condition=$column["column_name"]."  = ".(int)$params['search']['value'];
                    }else{
//                        if($column["data_type"]=="date"
                            $condition=$column["column_name"]."  LIKE '".$params['search']['value']."%'";
                        
                    }
                    if($pk==0){
                            $where .=" ".$condition." ";
                    }
                    else{
                        $where .=" OR ".$condition." ";
                    }
                }
                $where .=")";
//                
            }

            // getting total number records without any search
            $connect=Yii::app()->db;
            $sql="SELECT * FROM ". pg_escape_string($nameTable)." ";
            
            $sqlTot .= $sql;
            $sqlRec .= $sql;
            //concatenate search sql if value exist
            if(isset($where) && $where != '') {
                $sqlTot .= $where;
                $sqlRec .= $where;
            }
            if($params['length']==-1){
                $params['length']="all";
            }
            $sqlRec .=  " ORDER BY ". $columns[$params['order'][0]['column']]."   ".$params['order'][0]['dir']."  OFFSET ".$params['start']." LIMIT ".$params['length']." ";
            $query=$connect->createCommand($sqlRec);
            $read=$query->query();
            $results=$read->readAll();
            $read->close();
            
            /*total rows*/
            $sqlRC = "SELECT * FROM ". pg_escape_string($nameTable)." ";
            $queryNR=$connect->createCommand($sqlRC);
            $readNR=$queryNR->query();
            $resultsNC=$readNR->rowCount;
            $readNR->close();
            foreach($results as $pk=>$result){
                $i=0;
                foreach($columns as $pki=>$column){
                    $dataResult[$i]=$result[$column];
                    $i++;
                }
                $data[$pk]=$dataResult;
            }
            $json_data = array(
                "draw"            => intval( $params['draw'] ),   
                "recordsTotal"    => intval( $resultsNC ),  
                "recordsFiltered" => intval($resultsNC),
                "data"            => $data,
            );
        
            return $json_data;
        
        
    }
    public function createExcel($dir,$filename){
                ini_set('memory_limit', -1);
        require_once $dir. "../../vendor/autoload.php";
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($dir.$filename);
            $spreadSheet = $reader->load($dir.$filename);
             $dataAsAssocArray = $spreadSheet->getActiveSheet()->toArray();
//echo "<pre>";
//print_r($dataAsAssocArray);
//echo "</pre>";
//   
    
//        exit();
//        Yii::import('ext.phpexcelreader.JPhpExcelReader');
//        $data=new JPhpExcelReader($dir.$filename);
        $html_tb ='<table border="1"><tr>
            <th>NÚMERO de formulario</th>
            <th>Consecutivo 1</th>
            <th>Consecutivo 2</th>
            <th>descripción documento</th>
            <th>producto sin desagregar</th>
            <th>producto</th>
            <th>marca</th>
            <th>modelo</th>
            <th>referencia</th>
            <th>uso o destino</th>
            <th>técnica de diagnóstico</th>
            <th>serial</th>
            <th>fabricante</th>
            <th>pais s origen</th>
            <th>registro invima</th>
            <th>vencimiento</th>
            <th>expediente</th>
            <th>mercancía</th>
            <th>cantidad</th>
            <th>presentación</th>
            <th>domicilio</th></tr>';
        $order   = array("/\bDO\b/",
             "/NOMBRE PRODUCTO/",
            "/NOMBRE DEL PRODUCTO/",
            "/PRODUCTO:/",
            "/PRODUCTO=/",
            "/PRODUCTO./",
            "/PRODUCTO\_/",
            "/\bPRODUCTO\b/",
             "/\bMARCA\b/",
            "/\bMARCA:\b/",
            "/MODELO: SIN MODELO/",
            "/\bMODELO\b/",
            "/\bMOD\b/",
            "/\bMODELO:\b/",
            "/\bREFERENCIA\b/",
            "/\bREFERENCIA\_\b/",
            "/\bREFERENCIA:\b/",
            "/\bREF\b/",
            "/\bREF ERENCIA\b/",
            "/USO O DESTINO/",
            "/USO ESPECIFICO DE LA PARTE\s/",
            "/USO:/",
            "/USO O DESTINO:/",
            "/USO ESPECIFICO:/",
            "/TECNICA DE DIAGNOSTICO:/",
            "/FABRICANTES LEGALES/",
            "/PAIS DE ORIGEN/",
             "/REGISTRO SANITARIO INVIMA/",
            "/INVIMA NO./",
            "/REG. SANITARIO INVIMA/",
            "/REGISTRO SANITARIO:/",
            "/REGISTRO DE IMPORTACION:/",
            "/PERMISO DE COMERCIALIZACION INVIMA/",
            "/RSI: INVIMA/",
            "/REGISTRO S ANITARIO INVIMA NRO./",
            "/REGISTRO SANITARIO I NVIMA NRO./",
            "/REGISTRO SANIT ARIO INVIMA NRO./",
            "/REGISTRO SAN ITARIO INVIMA NRO./",
            "/REGISTRO SANITARIO INV IMA NRO./",
            "/REGISTRO SANITARIO INVI MA NRO./",
            "/REGISTRO SANI TARIO INVIMA NRO./",
            "/REGISTRO SA NITARIO INVIMA NRO./",
            "/REGISTRO SANITA RIO INVIMA NRO./",
            "/REGISTRO SANITAR IO INVIMA NRO./",
            "/REGISTRO SANITARIO: INVIMA/",
            "/MARCAREGISTRADA ANTE INVIMA:/",
            "/MARCA REGISTRADA ANTE INVIMA:/",
            "/\bVENCIMIENTO\b/",
            "/\bVIGENCIA\b/",
            "/\bEXPEDIENTE\b/",
            "/\bEXP\b/",
            "/MERCANCIA NUEVA/",
            "/SERIAL NO/",
            "/\bSERIAL\b/",
            "/\bSN\b/",
            "/\bDOMICILIO\b/",
            "/PRESENTACION COMERCIAL:/",
            "/\bCAJA\b/",
            "/\bCANTIDAD\b:/",
            "/\bCANTIDAD\b/",
            "/\bCANT\b/");
        $replace = array("|do|DO ",
           "|Np|pri|--|PROUDCTO|-|",
            "|Np|pri|--|PROUDCTO|-|",
            "|p|pr|--|PROUDCTO|-|",
            "|p|pr|--|PROUDCTO|-|",
            "|p|pr|--|PROUDCTO|-|",
            "|p|pr|--|PROUDCTO|-|",
            "|p|pr|--|PROUDCTO|-|",
            "|-|ma|--|MARCA|-|",
            "|-|ma|--|MARCA|-|",
            "|-|Smo|--|MODELO|-|",
            "|-|mo|--|MODELO|-|",
            "|-|mo|--|MODELO|-|",
            "|-|mo|--|MODELO|-|",
            "|-|ref|--|REFERENCIA|-|",
            "|-|ref|--|REFERENCIA|-|",
            "|-|ref|--|REFERENCIA|-|",
            "|-|ref|--|REFERENCIA|-|",
            "|-|ref|--|REFERENCIA|-|",
            "|-|ud|--|USO O DESTINO|-|",
            "|-|ud|--|USO O DESTINO|-|",
            "|-|udi|--|USO O DESTINO|-|",
            "|-|udi|--|USO O DESTINO|-|",
            "|-|udi|--|USO O DESTINO|-|",
            "|-|td|--|TECNICA DE DIAGNOSTICO|-|",
            "|-|fab|--|FABRICANTES LEGALES|-|",
            "|-|po|--|PAIS DE ORIGEN|-|",
            "|-|rinv|--|REGISTRO SANITARIO INVIMA|-|",
            "|-|rinv|--|REGISTRO SANITARIO INVIMA|-|",
            "|-|rinv|--|REGISTRO SANITARIO INVIMA|-|",
            "|-|rinv|--|REGISTRO SANITARIO INVIMA|-|",
            "|-|rinv|--|REGISTRO SANITARIO INVIMA|-|",
            "|-|rinv|--|REGISTRO SANITARIO INVIMA|-|",
            "|-|rinv|--|REGISTRO SANITARIO INVIMA|-|",
            "|-|rinv|--|REGISTRO SANITARIO INVIMA|-|",
            "|-|rinv|--|REGISTRO SANITARIO INVIMA|-|",
            "|-|rinv|--|REGISTRO SANITARIO INVIMA|-|",
            "|-|rinv|--|REGISTRO SANITARIO INVIMA|-|",
            "|-|rinv|--|REGISTRO SANITARIO INVIMA|-|",
            "|-|rinv|--|REGISTRO SANITARIO INVIMA|-|",
            "|-|rinv|--|REGISTRO SANITARIO INVIMA|-|",
            "|-|rinv|--|REGISTRO SANITARIO INVIMA|-|",
            "|-|rinv|--|REGISTRO SANITARIO INVIMA|-|",
            "|-|rinv|--|REGISTRO SANITARIO INVIMA|-|",
            "|-|rinv|--|REGISTRO SANITARIO INVIMA|-|",
            "|-|rinv|--|REGISTRO SANITARIO INVIMA|-|",
            "|-|rinv|--|REGISTRO SANITARIO INVIMA|-|",
            "|-|venc|--|VENCIMIENTO|-|",
            "|-|venc|--|VENCIMIENTO|-|",
            "|-|exp|--|EXPEDIENTE|-|",
            "|-|exp|--|EXPEDIENTE|-|",
            "|-|mn|--|MERCANCIA NUEVA|-|",
            "|-|ser|--|SERIAL|-|",
            "|-|ser|--|SERIAL|-|",
            "|-|ser|--|SERIAL|-|",
            "|-|dom|--|DOMICILIO|-|",
            "|-|caja|--|CAJAS|-|",
            "|-|caja|--|CAJAS|-|",
            "|-|cant|--|CANTIDAD|-|",
            "|-|cant|--|CANTIDAD|-|",
            "|-|cant|--|CANTIDAD|-|");
        $psSd=array();
        $orderi   = array("/\bDO\b/",
            "/PRODUCTO:/i",
            "/PRODUCTO=/i",
            "/PRODUCTO./i",
            "/PRODUCTO_/i",
            "/\bPRODUCTO\b/i");
	$replacei = array("|do|DO ",
            "|p|PROUDCTO",
            "|p|PROUDCTO",
            "|p|PROUDCTO",
            "|p|PROUDCTO",
            "|p|PROUDCTO");	
        $consec="";
        foreach($dataAsAssocArray as $alpha=>$data){
            
//            continue;
            if($alpha>0){
                $data[2]=$data[2];
                $auxCon=preg_replace($order, $replace,$data[2]);
                $auxConII=preg_replace($orderi, $replacei,$data[2]);
                $ps=explode("|p|",$auxCon);
                $psi=explode("|p|",$auxConII);
                $psSd[$alpha-2]=$psi;
                $arrProd[$alpha]["idprod"]=$data[0];
                $arrProd[$alpha]["do"]=$ps[0];
                
                unset($ps[0]);
                foreach($ps as $ini=>$ab){
                    $pii=explode("|-|",$ab);
                    $consecArr[$alpha][$ini][0]=$data[1];
                    $consecArr[$alpha][$ini][1]=$ini;
                    foreach($pii as $pk=>$ac){
                        $piii=explode("|--|",$ac);
                        if(count($piii)==2){
                            switch($piii[0]){
                                case "pr":
                                        $aux=$pk+1;
                                        //echo $aux."------producto - ".$pii[$pk+1]."<br>";
                                        $arrProd[$alpha]["cont"][$ini][0]= $pii[$pk+1];
                                break;
                                case "ma":
                                        $aux=$pk+1;
                                        //echo $aux."------marca - ".$pii[$pk+1]."<br>";
                                        $arrProd[$alpha]["cont"][$ini][1]=trim($pii[$pk+1],":,.");
                                break;
                                case "mo":
                                        $aux=$pk+1;
                                        //echo $aux."------modelo - ".$pii[$pk+1]."<br>";
                                        $arrProd[$alpha]["cont"][$ini][2]=trim($pii[$pk+1],":,.");
                                break;
                                case "ref":
                                        $aux=$pk+1;
                                        //echo $aux."------referencia - ".$pii[$pk+1]."<br>";
                                        $arrProd[$alpha]["cont"][$ini][3]=$pii[$pk+1];
                                break;
                                case "ud":
                                        $aux=$pk+1;
                                        //echo $aux."------uso o destino - ".$pii[$pk+1]."<br>";
                                        if(!isset($arrProd[$alpha]["cont"][$ini][4]) || empty($arrProd[$alpha]["cont"][$ini][4])){
                                                $arrProd[$alpha]["cont"][$ini][4]=$pii[$pk+1];
                                        }
                                        else{
                                                $arrProd[$alpha]["cont"][$ini][4].=$pii[$pk+1];
                                        }
                                break;
                                case "udi":
                                        $aux=$pk+1;
                                        //echo $aux."------uso o destino - ".$pii[$pk+1]."<br>";
                                        if(!isset($arrProd[$alpha]["cont"][$ini][4]) || empty($arrProd[$alpha]["cont"][$ini][4])){
                                                $arrProd[$alpha]["cont"][$ini][4]=$pii[$pk+1];
                                        }
                                        else{
                                                $arrProd[$alpha]["cont"][$ini][4].=$pii[$pk+1];
                                        }
                                break;
                                case "td":
                                        $aux=$pk+1;
                                        //echo $aux."------tecnica de diagnóstico - ".$pii[$pk+1]."<br>";
                                        $arrProd[$alpha]["cont"][$ini][5]=$pii[$pk+1];
                                break;
                                case "ser":
                                        $aux=$pk+1;
                                        //echo $aux."------serial - ".$pii[$pk+1]."<br>";
                                        $arrProd[$alpha]["cont"][$ini][6]=$pii[$pk+1];
                                break;
                                case "fab":
                                        $aux=$pk+1;
                                        //echo $aux."------fabricante - ".$pii[$pk+1]."<br>";
                                        $arrProd[$alpha]["cont"][$ini][7]=$pii[$pk+1];
                                break;
                                case "po":
                                        $aux=$pk+1;
                                        //echo $aux."------país de origen - ".$pii[$pk+1]."<br>";
                                        $arrProd[$alpha]["cont"][$ini][8]=$pii[$pk+1];
                                break;
                                case "rinv":
                                        $aux=$pk+1;
                                        //echo $aux."------registro invima - ".$pii[$pk+1]."<br>";
                                        $arrProd[$alpha]["cont"][$ini][9]=$pii[$pk+1];
                                break;
                                case "venc":
                                        $aux=$pk+1;
                                        //echo $aux."------vencimiento - ".$pii[$pk+1]."<br>";
                                        $arrProd[$alpha]["cont"][$ini][10]=$pii[$pk+1];
                                break;
                                case "exp":
                                        $aux=$pk+1;
                                        //echo $aux."------expediente - ".$pii[$pk+1]."<br>";
                                        $arrProd[$alpha]["cont"][$ini][11]=$pii[$pk+1];
                                break;
                                case "mn":
                                        $aux=$pk+1;
                                        //echo $aux."------mercancia nueva - ".$pii[$pk+1]."<br>";
                                        $arrProd[$alpha]["cont"][$ini][12]=$pii[$pk+1];
                                break;
                                case "cant":
                                        $aux=$pk+1;
                                        //echo $aux."------mercancia nueva - ".$pii[$pk+1]."<br>";
                                        $arrProd[$alpha]["cont"][$ini][13]=$pii[$pk+1];
                                break;
                                case "caja":
                                        $aux=$pk+1;
                                        //echo $aux."------mercancia nueva - ".$pii[$pk+1]."<br>";
                                        $arrProd[$alpha]["cont"][$ini][14]=$pii[$pk+1];
                                break;
                                case "dom":
                                        $aux=$pk+1;
                                        //echo $aux."------mercancia nueva - ".$pii[$pk+1]."<br>";
                                        $arrProd[$alpha]["cont"][$ini][15]=$pii[$pk+1];
                                break;
                            }
                        }
                    }
                    ksort($arrProd[$alpha]["cont"][$ini]);
                }
            }
        }
//        echo "<pre>";
//            print_r($arrProd);
//            echo "</pre>";
//            
//        exit();
        foreach($arrProd as $lp=>$prod){
            if(isset($prod["cont"]) && is_array($prod["cont"])){
                foreach($prod["cont"] as  $lpi=>$lpas){
                    for($i=0;$i<=15;$i++){
                        if($i==14 && isset($lpas[13])){
                            $pres=explode(" ",$arrProd[$lp]["cont"][$lpi][13]);
                            if(is_array($pres) && count($pres)>=2){
                                if(isset($pres[2])){
                                        $arrProd[$lp]["cont"][$lpi][$i]=$pres[2];
                                }
                                else{
                                        $arrProd[$lp]["cont"][$lpi][$i]="S.I";
                                }
                            }
                        }
                        else if(!isset($lpas[$i])){
                                $arrProd[$lp]["cont"][$lpi][$i]="S.I";
                        }
                    }
                    ksort($arrProd[$lp]["cont"][$lpi]);
                }
            }
        }
        
        foreach($arrProd as $lp=>$prod){
            $cont=0;
            if(isset($prod["cont"]) && is_array($prod["cont"])){
                foreach($prod["cont"] as  $lpi=>$lpas){
                    $html_tb.="<tr>";
                    $html_tb.="<td>".$prod["idprod"]."</td>";
                    $html_tb.="<td>".$consecArr[$lp][$lpi][0]."</td>";
                    $html_tb.="<td>".$consecArr[$lp][$lpi][1]."</td>";
                    $html_tb.="<td>".$prod["do"]."</td>";
                    $html_tb.="<td>".$psSd[$lp-2][$lpi]."</td>";
                    foreach($lpas as  $lpasi){
                        $html_tb.="<td>".$lpasi."</td>";
                    }
                    $html_tb.="</tr>";
                }
            }
            else{
                $html_tb.="<tr>";
                $html_tb.="<td>".$prod["idprod"]."</td>";
                $html_tb.="<td>1</td>";
                $html_tb.="<td> </td>";
                $html_tb.="<td>".$prod["do"]."</td>";
                $html_tb.="</tr>";
            }
        }
//        
	  $html_tb.="</table>";      
        header("Content-type: application/vnd.ms-excel");
        header("Content-type: application/force-download");
        header("Content-Disposition: attachment; filename=datosProc.xls");
        header("Pragma: no-cache"); 
        echo  utf8_decode($html_tb);
    }
    
    public function loadCapitulo($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO capitulo (idvar_capitulo,id_seccion,nombre_capitulo) VALUES (:idvar_capitulo,:id_seccion,:nombre_capitulo)";
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        $varSalida="";
        foreach($data->sheets[0]['cells'] as $pk=>$data){
//            echo $data[2]." ";
            if($pk>1){
                $modeloCapitulo= Capitulo::model()->findByAttributes(array("idvar_capitulo"=>$data[1]));
                if(empty($modeloCapitulo) || !is_object($modeloCapitulo)){
                    $modeloSeccion= Seccion::model()->findByAttributes(array("idvar_seccion"=>$data[2]));
                    try{
                        if(empty($modeloSeccion)){throw new Exception("2");}else{$data[2]=$modeloSeccion->id_seccion;}
                        (empty($data[3]))?$data[3]="":$data[3]=utf8_encode($data[3]);
                        $query->bindParam(":idvar_capitulo",$data[1]);
                        $query->bindParam(":id_seccion",$data[2]);
                        $query->bindParam(":nombre_capitulo",$data[3]);
                        $query->execute(); 
                    }
                    catch(Exception $e){
                        $registro=$pk+1;
                        $varSalida.="No se cargó el registro No. ".$pk." error en el campo No. ".$e->getMessage();
                        $varSalida.="\n---------------------\n";
                    }
                }
            }
        }
        return $varSalida;
    }
    public function loadGrupo($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO grupo (idvar_grupo,id_capitulo,nombre_grupo) VALUES (:idvar_grupo,:id_capitulo,:nombre_grupo)";
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        $varSalida="";
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $modeloGrupo= Grupo::model()->findByAttributes(array("idvar_grupo"=>$data[1]));
                if(empty($modeloGrupo) || !is_object($modeloGrupo)){
                    $modeloCapitulo= Capitulo::model()->findByAttributes(array("idvar_capitulo"=>$data[2]));
                    try{
                        if(empty($modeloCapitulo)){throw new Exception("2");}else{$data[2]=$modeloCapitulo->id_capitulo;}
                        (empty($data[3]))?$data[3]="":$data[3]=utf8_encode($data[3]);
                        $query->bindParam(":idvar_grupo",$data[1]);
                        $query->bindParam(":id_capitulo",$data[2]);
                        $query->bindParam(":nombre_grupo",$data[3]);
                        $query->execute(); 
                    }
                    catch(Exception $e){
                        $registro=$pk+1;
                        $varSalida.="No se cargó el registro No. ".$pk." error en el campo No. ".$e->getMessage();
                        $varSalida.="\n---------------------\n";
                    }
                }
            }
        }
        return $varSalida;
    }
    public function loadSubGrupo($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO subgrupo (idvar_subgrupo,id_grupo,nombre_subgrupo) VALUES (:idvar_subgrupo,:id_grupo,:nombre_subgrupo)";
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        $varSalida="";
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $modeloSubgrupo= Subgrupo::model()->findByAttributes(array("idvar_subgrupo"=>$data[1]));
                if(empty($modeloSubgrupo) || !is_object($modeloSubgrupo)){
                    $modeloGrupo= Grupo::model()->findByAttributes(array("idvar_grupo"=>$data[2]));
                    try{
                        if(empty($modeloGrupo)){throw new Exception("2");}else{$data[2]=$modeloGrupo->id_grupo;}
                        (empty($data[3]))?$data[3]="":$data[3]=utf8_encode($data[3]);
                        $query->bindParam(":idvar_subgrupo",$data[1]);
                        $query->bindParam(":id_grupo",$data[2]);
                        $query->bindParam(":nombre_subgrupo",$data[3]);
                        $query->execute(); 
                    }
                    catch(Exception $e){
                        $registro=$pk+1;
                        $varSalida.="No se cargó el registro No. ".$pk." error en el campo No. ".$e->getMessage();
                        $varSalida.="\n---------------------\n";
                    }
                }
            }
        }
        return $varSalida;
    }
    public function loadCategoria($dir,$filename,$tablename){
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($dir.$filename);
        $sql="INSERT INTO categoria (idvar_categoria,id_subgrupo,nombre_categoria) VALUES (:idvar_categoria,:id_subgrupo,:nombre_categoria)";
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        $varSalida="";
        foreach($data->sheets[0]['cells'] as $pk=>$data){
            if($pk>1){
                $modeloCategoria= Categoria::model()->findByAttributes(array("idvar_categoria"=>$data[1]));
                if(empty($modeloCategoria) || !is_object($modeloCategoria)){
                    $modeloSubgrupo= Subgrupo::model()->findByAttributes(array("idvar_subgrupo"=>$data[2]));
                    $data[2]=$modeloSubgrupo->id_subgrupo;
                    try{
                        if(empty($modeloSubgrupo)){throw new Exception("2");}else{$data[2]=$modeloSubgrupo->id_subgrupo;}
                        (empty($data[3]))?$data[3]="":$data[3]=utf8_encode($data[3]);
                        $query->bindParam(":idvar_categoria",$data[1]);
                        $query->bindParam(":id_subgrupo",$data[2]);
                        $query->bindParam(":nombre_categoria",$data[3]);
                        $query->execute(); 
                    }
                    catch(Exception $e){
                        $registro=$pk+1;
                        $varSalida.="No se cargó el registro No. ".$pk." error en el campo No. ".$e->getMessage();
                        $varSalida.="\n---------------------\n";
                    }
                }
            }
        }
        return $varSalida;
    }
    public function consultaEntidad($entidad){
        $sql="SELECT * FROM ".pg_escape_string($entidad);
        $conn=Yii::app()->db;
        $query=$conn->createCommand($sql);
        $read=$query->query();
        $res=$read->readAll();
        $read->close();
        return $res;
    }
}