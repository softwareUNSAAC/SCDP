begin

    create temporary table resumen1(
        equipo int(11) NOT NULL,
        partido int(11) NOT NULL,
        goles int (11) NOT NULL
        );
        insert into resumen1( equipo ,partido,goles)
        select J.codequipo, P.codpartido, count(distinct O.idgol)as goles
            from tjugadorenjuego as E
            join tpartido as P on E.codpartido = P.codpartido
            join tgol as O on E.idjugadorenjuego = O.idjugadorenjuego
            join tjugador as J on E.idjugador=J.idjugador
            join tequipo as Q on J.codequipo=Q.codequipo
            group by J.codequipo, P.codpartido;
create temporary table resumen2(
        partido int(11) NOT NULL,
        goles1 int (11) NOT NULL
        );
        insert into resumen2( partido ,goles1)
        select P.codpartido, count(distinct O.idgol)as goles
            from tjugadorenjuego as E
            join tpartido as P on E.codpartido = P.codpartido
            join tgol as O on E.idjugadorenjuego = O.idjugadorenjuego
            join tjugador as J on E.idjugador=J.idjugador
            join tequipo as Q on J.codequipo=Q.codequipo
            group by P.codpartido;

create temporary table resumen3(
        partido int(11) NOT NULL,
        equipo int(11) NOT NULL,
        golesafavor int (11) NOT NULL,
        golesencontra int(11) NOT NULL
        );
        insert into resumen3( partido ,equipo ,golesafavor,golesencontra)
        select P.partido, E.equipo,E.goles,(P.goles1-E.goles)as golesencontra
            from resumen1 as E
            join resumen2 as P on E.partido = P.partido;


 create temporary table resumen4(
        partido int(11) NOT NULL,
        equipo int(11) NOT NULL,
        GF int (11) NOT NULL,
        GE int(11) NOT NULL,
        DG int(11) NOT NULL
        );
        insert into resumen4( partido ,equipo ,GF,GE,DG)
 select partido,equipo ,sum(golesafavor)as GF,sum(golesencontra)as GE,(sum(golesafavor)-sum(golesencontra))as DG from resumen3
      group by partido,equipo;

create temporary table resumen5(

        equipo int (11) NOT NULL,
        partido int(11) NOT NULL,
        puntaje int (11) NOT NULL,
        PJ int (11) NOT NULL,
        PG int (11) NOT NULL,
        PE int (11) NOT NULL,
        PP int (11) NOT NULL

        );
        insert into resumen5(equipo ,partido,puntaje,PJ,PG,PE,PP)
        select O.codequipo,P.codpartido, sum(E.puntaje) as puntaje ,count(distinct P.codpartido) as PJ,
            sum(case when E.puntaje=3 then 1 else 0 end ) as PG,
            sum(case when E.puntaje=1 then 1 else 0 end ) as PE,
            sum(case when E.puntaje=0 then 1 else 0 end ) as PP
            from tequipoenpartido as E
            join tpartido as P on E.codpartido = P.codpartido
            join tequipo as O on E.codequipo = O.codequipo
            group by o.codequipo, P.codpartido;


 create temporary table resumen6(

        equipo int (11) NOT NULL,
        PJ int (11) NOT NULL,
        PG int (11) NOT NULL,
        PE int (11) NOT NULL,
        PP int (11) NOT NULL,
        GF int (11) NOT NULL,
        GE int (11) NOT NULL,
        DG int (11) NOT NULL,
        puntaje int (11) NOT NULL
        );


insert into resumen6(equipo ,PJ,PG,PE,PP,GF,GE,DG,puntaje)
        select G.equipo,sum(P.PJ),sum(P.PG),sum(P.PE),sum(P.PP),sum(G.GF),sum(G.GE),sum(G.DG),sum(P.puntaje)
            from resumen4 as G
            join resumen5 as P on G.partido = P.partido
            AND G.equipo=P.equipo
            group by G.equipo
           ;

 select * from resumen6c
 ORDER BY puntaje DESC;
      drop table resumen6;
 end


create temporary table resumen6(

        partido VARCHAR (8) NOT NULL,
        equipo1 VARCHAR (8) NOT NULL,
        equipo2 VARCHAR (8) NOT NULL,
        nro int (11) NOT NULL,
        PG1 int (11) NOT NULL,
        PG2 int (11) NOT NULL,
        PE int (11) NOT NULL
        );
insert into resumen6(partido ,equipo1,equipo2,nro,PG1,PG2,PE)
   select P.codPartido,E1.codEquipo,E2.codEquipo,count(distinct P.codPartido) as PJ,
            sum(case when( P.resultado= -3)then 1 else 0 end ) as PGE1,
            sum(case when P.resultado= 3 then 1 else 0 end ) as PGE2,
            sum(case when P.resultado= 0 then 1 else 0 end ) as PE
            from tfixture as E
            join tpartido as P on E.codPartido = P.codPartido
            join tequipo as E1 on E.codEquipo1 = E1.codEquipo
            join tequipo as E2 on E.codEquipo2 = E2.codEquipo
            where P.termino='2'
            group by P.codPartido,E1.codEquipo,E2.codEquipo;





select R6.equipo1, count(nro),
sum();
      FROM resumen6 as R6;





create temporary table resumen6(

        partido VARCHAR (8) NOT NULL,
        equipo VARCHAR (8) NOT NULL,
        nro int (11) NOT NULL,
        PG int (11) NOT NULL,
        PP int (11) NOT NULL,
        PE int (11) NOT NULL
        );
insert into resumen6(partido,equipo,nro,PG,PP,PE)

select P.codPartido ,E1.codEquipo,count(distinct P.codPartido) as PJ,
            sum(case when( P.resultado= -3)then 1 else 0 end ) as PGE1,
             sum(case when( P.resultado= 3)then 1 else 0 end ) as PP1,
            sum(case when P.resultado= 0 then 1 else 0 end ) as PE
            from tfixture as E
            join tpartido as P on E.codPartido = P.codPartido
            join tequipo as E1 on E.codEquipo1 = E1.codEquipo
            where P.termino='2'
            group by P.codPartido,  E1.codEquipo
UNION
select P.codPartido,E1.codEquipo,count(distinct P.codPartido) as PJ,

            sum(case when( P.resultado= 3)then 1 else 0 end ) as PGE1,
            sum(case when( P.resultado= -3)then 1 else 0 end ) as PP1,
            sum(case when P.resultado= 0 then 1 else 0 end ) as PE
            from tfixture as E
            join tpartido as P on E.codPartido = P.codPartido
            join tequipo as E1 on E.codEquipo2 = E1.codEquipo
            where P.termino='2'
            group by P.codPartido,E1.codEquipo;


create temporary table resumen7(

        equipo VARCHAR (8) NOT NULL,
        PJ int (11) NOT NULL,
        PG int (11) NOT NULL,
        PP int (11) NOT NULL,
        PE int (11) NOT NULL
        );

insert into resumen7(equipo,nro,PG,PP,PE)

select equipo,sum(nro) as PJ,sum(PG) as PG,sum(PP) as PP,sum(PE) as PE
            from resumen6
            group by  equipo;


select * from resumen7;
      drop table resumen7;




create temporary table resumen6(

        partido VARCHAR (8) NOT NULL,
        equipo VARCHAR (8) NOT NULL,
        nro int (11) NOT NULL,
        PG int (11) NOT NULL,
        PP int (11) NOT NULL,
        PE int (11) NOT NULL
        );
insert into resumen6(partido,equipo,nro,PG,PP,PE)

select P.codPartido ,E1.codEquipo,count(distinct P.codPartido) as PJ,
            sum(case when( P.resultado= -3)then 1 else 0 end ) as PGE1,
             sum(case when( P.resultado= 3)then 1 else 0 end ) as PP1,
            sum(case when P.resultado= 0 then 1 else 0 end ) as PE
            from tfixture as E
            join tpartido as P on E.codPartido = P.codPartido
            join tequipo as E1 on E.codEquipo1 = E1.codEquipo
            where P.termino='2'
            group by P.codPartido,  E1.codEquipo
UNION
select P.codPartido,E1.codEquipo,count(distinct P.codPartido) as PJ,

            sum(case when( P.resultado= 3)then 1 else 0 end ) as PGE1,
            sum(case when( P.resultado= -3)then 1 else 0 end ) as PP1,
            sum(case when P.resultado= 0 then 1 else 0 end ) as PE
            from tfixture as E
            join tpartido as P on E.codPartido = P.codPartido
            join tequipo as E1 on E.codEquipo2 = E1.codEquipo
            where P.termino='2'
            group by P.codPartido,E1.codEquipo;


create temporary table resumen7(

        equipo VARCHAR (8) NOT NULL,
        PJ int (11) NOT NULL,
        PG int (11) NOT NULL,
        PP int (11) NOT NULL,
        PE int (11) NOT NULL,
    	PU int (11) NOT NULL
        );

insert into resumen7(equipo,PJ,PG,PP,PE,PU)

select equipo,sum(nro) as PJ,sum(PG) as PG,sum(PP) as PP,sum(PE) as PE,sum(CASE when PG= 1 THEN 3

                                                                           ELSE
                                                                           CASE WHEN PE=1 THEN 1
                                                                           ELSE 0
                                                                           END
                                                                           END
                                                                       	)AS PU



            from resumen6
            group by  equipo;


select * from resumen7;
      drop table resumen7