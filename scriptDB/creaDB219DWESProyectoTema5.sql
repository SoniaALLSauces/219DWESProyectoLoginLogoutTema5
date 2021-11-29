/**
 * Author:  Sonia Antón Llanes
 * Created: 26 nov. 2021
 * Last Modify: 26 nov. 2021
 */


    /* Creo la base de datos DAW2xxxDBDepartamentos */
        create database if not exists DB219DWESProyectoTema5;

    /* Creo el usuario */
        create user if not exists 'user219DWESProyectoTema5'@'%' identified by 'paso';

    /* Damos permisos al usuario sobre la base de datos DB219DWESProyectoTema5 */
        grant all privileges on DB219DWESProyectoTema5.* to 'user219DWESProyectoTema5'@'%';

    /* Pongo en uso la base de datos creada en script DB219DWESProyectoTema5 */
        use DB219DWESProyectoTema5;  

    /* Creo la tabla Usuarios si no existe */
        create table if not exists T01_Usuario(  
            T01_CodUsuario varchar(8) primary key not null,
            T01_Password varchar(8),
            T01_DescUsuario varchar(255),
            T01_NumConexiones int default 0,
            T01_FechaHoraUltimaConexion timestamp,
            T01_Perfil enum('usuario','administrador') default 'usuario',
            T01_ImagenUsuario mediumblob) engine=innodb;

    /* Creo la tabla Departamentos si no existe */
        create table if not exists T02_Departamento(  
            T02_CodDepartamento varchar(3) primary key not null,
            T02_DescDepartamento varchar(255),
            T02_FechaCreacionDepartamento timestamp default current_timestamp,
            T02_VolumenDeNegocio float,
            T02_FechaBajaDepartamento date) engine=innodb;

    

