SELECT * FROM ptylcudo_mect.coaching_usuarios;
SELECT * FROM ptylcudo_mect.examenes_reactivos;
SELECT * FROM ptylcudo_mect.examenes_reactivos_usuarios;
SELECT * FROM ptylcudo_mect.examenes_usuarios;
SELECT * FROM ptylcudo_mect.grupos;
SELECT * FROM ptylcudo_mect.jornada_usuarios;
SELECT * FROM ptylcudo_mect.modulo_personal;
SELECT * FROM ptylcudo_mect.modulos;
SELECT * FROM ptylcudo_mect.modulos_grupos;
SELECT * FROM ptylcudo_mect.modulos_info;
SELECT * FROM ptylcudo_mect.modulos_usuarios;
SELECT * FROM ptylcudo_mect.notificaciones;
SELECT * FROM ptylcudo_mect.trabajos_usuarios WHERE id_usuario=19 and revisado>0;
SELECT * FROM ptylcudo_mect.trabajos_modulos;
SELECT * FROM ptylcudo_mect.usuarios;
SELECT * FROM ptylcudo_mect.usuario_web;

select * from trabajos_usuarios tu
inner join trabajos_modulos tm on tm.id_trabajo = tu.id_trabajo
inner join usuarios u on tu.id_usuario = u.id
where u.login_user = 'salvador.juarez';

INSERT INTO trabajos_usuarios (id_trabajo, id_usuario)
SELECT tm.id_trabajo, u.id
FROM trabajos_modulos tm, usuarios u
WHERE u.id_grupo=10 AND tm.id_modulo > 2;


select count(c.id), u.nombre, u.apellidos from coaching_usuarios c join usuarios u on c.id_usuario = u.id where u.id_grupo=8 and u.status=0 group by u.id;
select count(c.id), u.nombre, u.apellidos from coaching_usuarios c join usuarios u on c.id_usuario = u.id where u.id=19;