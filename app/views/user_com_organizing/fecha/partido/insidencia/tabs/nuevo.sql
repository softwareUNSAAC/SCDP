DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Jugadorgoles`(IN `partido` VARCHAR (8), IN `jugadr` VARCHAR (8))
begin

    create temporary table resumen(
        jugador VARCHAR (8) NOT NULL,
        goles int (11) NOT NULL
        );
        insert into resumen( jugador ,goles)
        select J.dni, count(distinct O.idgol)as goles

            from tpartido as P
            join tgol as O on P.codPartido = O.codPartido
            join tjugadorjuego E on O.codjugPart = E.codjugPart
            join tjugador as J on E.dni=J.dni
            join tequipo as Q on J.codEquipo=Q.codEquipo
            where P.codPartido=partido and J.dni=jugadr
            group by J.dni;
 select * from resumen;
      drop table resumen;
 end$$
DELIMITER ;


DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `TABLA`()
begin
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
      drop table resumen7;
 end$$
DELIMITER ;



DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `GOLES`()
begin
create temporary table resumen6(

        partido VARCHAR (8) NOT NULL,
        equipo VARCHAR (8) NOT NULL,
        GF int (11) NOT NULL,
        GC int (11) NOT NULL,
        DG int (11) NOT NULL
        );
insert into resumen6(partido,equipo,nro,PG,PP,PE)

select P.codPartido ,E1.codEquipo,
            from tpartido as p
            join tgol as G on E.codPartido = P.codPartido
            join tjugadorjuego   codjugPart as Jp
            join tjugador as E1 on E.codEquipo1 = E1.codEquipo
            join tequipo as E1 on E.codEquipo1 = E1.codEquipo
            where P.termino='2';


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
      drop table resumen7;
 end$$


DELIMITER ;

create temporary table resumen(

        partido VARCHAR (8) NOT NULL,
        equipo VARCHAR (8) NOT NULL,
        GOLES int (11) NOT NULL,
        );
insert into resumen(partido,equipo,GOLES)

select P.codPartido,E.codEquipo ,COUNT(G.idgol) AS GOLES
            from tpartido as p
            join tgol as G on P.codPartido = G.codPartido
            join tjugadorjuego AS JJ ON JJ.codjugPart=  G.codjugPart
            join tjugador as J on JJ.dni = J.dni
            join tequipo as E on J.codEquipo = E.codEquipo
            where P.termino='2'
            GROUP BY P.codPartido,E.codEquipo;

select  from resumen;
      drop table resumen;



DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `GOLEADORES`()
begin


select  JJ.dni as dni ,COUNT(G.idgol) goles
            from tpartido as p
            join tgol as G on P.codPartido = G.codPartido
            join tjugadorjuego AS JJ ON JJ.codjugPart=  G.codjugPart
            join tjugador as J on JJ.dni = J.dni
            join tequipo as E on J.codEquipo = E.codEquipo
            where P.termino='2'
            GROUP BY JJ.dni;


end$$


DELIMITER ;















create temporary table resumen(

        partido VARCHAR (8) NOT NULL,
        equipo VARCHAR (8) NOT NULL,
        GOLES int (11) NOT NULL
        );
insert into resumen(partido,equipo,GOLES)

select P.codPartido,E.codEquipo ,COUNT(G.idgol) AS GOLES
            FROM tfixture as F
            join tpartido as p on F.codPartido=P.codPartido
            join tgol as G on P.codPartido = G.codPartido
            join tjugadorjuego AS JJ ON JJ.codjugPart=  G.codjugPart
            join tjugador as J on JJ.dni = J.dni
            join tequipo as E on J.codEquipo = E.codEquipo
            where P.termino='2'
            GROUP BY P.codPartido,E.codEquipo;

select equipo,sum(goles)
	from resumen
    GROUP BY equipo;

      drop table resumen;

select E.codEquipo, COUNT(G.idgol) AS GOLES
            FROM tfixture as F
            join tpartido as P on F.codPartido=P.codPartido
            join tgol as G on P.codPartido = G.codPartido
            join tjugadorjuego AS JJ ON JJ.codjugPart=  G.codjugPart
            join tjugador as J on JJ.dni = J.dni
            join tequipo as E on J.codEquipo = E.codEquipo
            where P.termino='2'
            GROUP BY E.codEquipo;






///

create temporary table resumen(


        equipo VARCHAR (8) NOT NULL,
        GC int (11) NOT NULL
        );
insert into resumen(equipo,GC)
			select F.codEquipo1,COUNT(G.idgol) AS GOLES
            FROM tfixture as F
            join tpartido as p on F.codPartido=P.codPartido
            join tgol as G on P.codPartido = G.codPartido
            join tjugadorjuego AS JJ ON JJ.codjugPart=  G.codjugPart
            join tjugador as J on JJ.dni = J.dni
            join tequipo as E on J.codEquipo = E.codEquipo
            AND E.codEquipo=F.codEquipo2
            where P.termino='2'
            GROUP BY F.codEquipo1

            UNION
            select F.codEquipo2,COUNT(G.idgol) AS GOLES
            FROM tfixture as F
            join tpartido as p on F.codPartido=P.codPartido
            join tgol as G on P.codPartido = G.codPartido
            join tjugadorjuego AS JJ ON JJ.codjugPart=  G.codjugPart
            join tjugador as J on JJ.dni = J.dni
            join tequipo as E on J.codEquipo = E.codEquipo
            AND E.codEquipo=F.codEquipo1
            where P.termino='2'
            GROUP BY F.codEquipo2;


create temporary table resumen1(


        equipo VARCHAR (8) NOT NULL,
        GC int (11) NOT NULL
        );
        insert into resumen1(equipo,GC)
        select equipo,sum(GC)
	      from resumen
          GROUP BY equipo;

create temporary table resumen2(


        equipo VARCHAR (8) NOT NULL,
        GF int (11) NOT NULL
        );
insert into resumen2(equipo,GF)
select E.codEquipo, COUNT(G.idgol) AS GOLES
            FROM tfixture as F
            join tpartido as P on F.codPartido=P.codPartido
            join tgol as G on P.codPartido = G.codPartido
            join tjugadorjuego AS JJ ON JJ.codjugPart=  G.codjugPart
            join tjugador as J on JJ.dni = J.dni
            join tequipo as E on J.codEquipo = E.codEquipo
            where P.termino='2'
            GROUP BY E.codEquipo;


create temporary table resumen3(


        equipo VARCHAR (8) NOT NULL,
        GF int (11) NOT NULL,
        GC int (11) NOT NULL,
        DG int (11) NOT NULL
        );
insert into resumen3(equipo,GF,GC,DG)
      select R1.equipo,R1.GF,R2.GC (P.goles1-E.goles) as GOLES
            FROM resumen1 as R1
            join resumen2 as R2 on R1.equipo=R2.equipo

            GROUP BY E.codEquipo;

select * from resumen3;
      drop table resumen3;









DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `GOLES`()
begin



create temporary table resumen(


        equipo VARCHAR (8) NOT NULL,
        GC int (11) NOT NULL
        );
insert into resumen(equipo,GC)
			select F.codEquipo1,COUNT(G.idgol) AS GOLES
            FROM tfixture as F
            join tpartido as p on F.codPartido=P.codPartido
            join tgol as G on P.codPartido = G.codPartido
            join tjugadorjuego AS JJ ON JJ.codjugPart=  G.codjugPart
            join tjugador as J on JJ.dni = J.dni
            join tequipo as E on J.codEquipo = E.codEquipo
            AND E.codEquipo=F.codEquipo2
            where P.termino='2'
            GROUP BY F.codEquipo1

            UNION
            select F.codEquipo2,COUNT(G.idgol) AS GOLES
            FROM tfixture as F
            join tpartido as p on F.codPartido=P.codPartido
            join tgol as G on P.codPartido = G.codPartido
            join tjugadorjuego AS JJ ON JJ.codjugPart=  G.codjugPart
            join tjugador as J on JJ.dni = J.dni
            join tequipo as E on J.codEquipo = E.codEquipo
            AND E.codEquipo=F.codEquipo1
            where P.termino='2'
            GROUP BY F.codEquipo2;


create temporary table resumen1(


        equipo VARCHAR (8) NOT NULL,
        GC int (11) NOT NULL
        );
        insert into resumen1(equipo,GC)
        select equipo,sum(GC)
	      from resumen
          GROUP BY equipo;

create temporary table resumen2(


        equipo VARCHAR (8) NOT NULL,
        GF int (11) NOT NULL
        );
insert into resumen2(equipo,GF)
select E.codEquipo, COUNT(G.idgol) AS GOLES
            FROM tfixture as F
            join tpartido as P on F.codPartido=P.codPartido
            join tgol as G on P.codPartido = G.codPartido
            join tjugadorjuego AS JJ ON JJ.codjugPart=  G.codjugPart
            join tjugador as J on JJ.dni = J.dni
            join tequipo as E on J.codEquipo = E.codEquipo
            where P.termino='2'
            GROUP BY E.codEquipo;


create temporary table resumen3(


        equipo VARCHAR (8) NOT NULL,
        GF int (11) NOT NULL,
        GC int (11) NOT NULL,
        DG int (11) NOT NULL
        );
insert into resumen3(equipo,GF,GC,DG)
      select R1.equipo,R2.GF,R1.GC ,(R2.GF - R1.GC) as GOLES
            FROM resumen1 as R1
            join resumen2 as R2 on R1.equipo=R2.equipo
;

select * from resumen3;
      drop table resumen3;
 end$$
DELIMITER ;