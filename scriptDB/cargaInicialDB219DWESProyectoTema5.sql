/**
 * Author:  Sonia Antón Llanes
 * Created: 26 nov. 2021
 */


    /* Pongo en uso la base de datos creada en script creaDAW2SALDBDepartamentos */
        use DB219DWESProyectoTema5;  

        /* Inserto las tuplas a la tabla Usuarios*/
        INSERT INTO Usuario(CodDepartamento,DescDepartamento,FechaBaja,VolumenNegocio) VALUES

    /* Inserto las tuplas a la tabla Departamentos*/
        INSERT INTO T02_Departamento(T02_CodDepartamento,T02_DescDepartamento,T02_VolumenDeNegocio,T02_FechaBajaDepartamento) VALUES
            ('INF', 'Departamento de informatica',1,null),
            ('VEN', 'Departamento de ventas',2,null),
            ('CON', 'Departamento de contabilidad',3,null),
            ('MTO', 'Departamento de mantenimiento',5,null),
            ('ADM', 'Departamento de administracion',6,null);

    /* Inserto las tuplas a la tabla Usuarios*/
        INSERT INTO T01_Usuario(T01_CodUsuario,T01_Password,T01_DescUsuario) VALUES
            ('outmane',SHA2('outmanepaso',256),'Outmane'),
            ('rodrigo',SHA2('rodrigopaso',256),'Rodrigo'),
            ('isabel',SHA2('isabelpaso',256),'Isabel'),
            ('david',SHA2('davidpaso',256),'David'),
            ('albertoF',SHA2('albertoFpaso',256),'AlbertoF'),
            ('aroa',SHA2('aroapaso',256),'Aroa'),
            ('johanna',SHA2('johannapaso',256),'Johanna'),
            ('oscar',SHA2('oscarpaso',256),'Oscar'),
            ('sonia',SHA2('soniapaso',256),'Sonia'),
            ('heraclio',SHA2('heracliopaso',256),'Heraclio'),
            ('amor',SHA2('amorpaso',256),'Amor'),
            ('antonio',SHA2('antoniopaso',256),'Antonio'),
            ('albertoB',SHA2('albertoBpaso',256),'AlbertoB');
            
    /* Usuario administrador con el rol de administrador */
        INSERT INTO T01_Usuario(T01_CodUsuario, T01_Password, T01_DescUsuario, T01_Perfil) VALUES
            ('admin',SHA2('adminpaso',256),'Admin','administrador');


