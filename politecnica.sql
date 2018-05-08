DELIMITER $$
CREATE OR REPLACE PROCEDURE `sp_despesas_grupos` (IN `ano` INT)  NO SQL
BEGIN 
    DECLARE i INT DEFAULT 1;
	DECLARE j VARCHAR(2);

    WHILE i <= 12 DO

    	set j = i;

		IF(i < 10) THEN
			set j = CONCAT('0',i);
		END IF;

		/*limpar dados*/
		DELETE FROM despesas_grupos
        WHERE dt_despesa = CONCAT(j,'/',ano);
		commit;
	
    	INSERT INTO despesas_grupos
        	(id_grupo, dt_despesa, nb_despesa)
            (SELECT
             	grupos.id_grupo,
             	CONCAT(j,'/',ano) as dt_despesa,
             	IFNULL(sum(horas_projetos_funcionarios.nb_despesa),0) as nb_despesa
            FROM horas_projetos_funcionarios, grupos
            WHERE horas_projetos_funcionarios.id_grupo = grupos.id_grupo
            AND MONTH(horas_projetos_funcionarios.dt_trabalho) = i
            AND YEAR(horas_projetos_funcionarios.dt_trabalho) = ano
            GROUP BY horas_projetos_funcionarios.id_grupo
            ORDER BY horas_projetos_funcionarios.id_grupo);
        
        set i=i+1;
        
    END WHILE;
END$$

CREATE OR REPLACE PROCEDURE `sp_horas_grupos` (IN `ano` INT)  BEGIN 
    DECLARE i INT DEFAULT 1;
	DECLARE j VARCHAR(2);

    WHILE i <= 12 DO

    	set j = i;

		IF(i < 10) THEN
			set j = CONCAT('0',i);
		END IF;

		/*limpar dados*/
		DELETE FROM horas_grupos
        WHERE dt_horas = CONCAT(j,'/',ano);
		commit;
	
    	INSERT INTO horas_grupos
        	(id_grupo, dt_horas, nb_horas)
            (SELECT
             	horas_projetos_funcionarios.id_grupo,
             	CONCAT(j,'/',ano) as dt_horas,
             	IFNULL(sum(horas_projetos_funcionarios.nb_horas_trabalho),0) as nb_horas
            FROM horas_projetos_funcionarios
            WHERE MONTH(horas_projetos_funcionarios.dt_trabalho) = i
            AND YEAR(horas_projetos_funcionarios.dt_trabalho) = ano
            GROUP BY horas_projetos_funcionarios.id_grupo
            ORDER BY horas_projetos_funcionarios.id_grupo);
        
        set i=i+1;
        
    END WHILE;
END$$

CREATE OR REPLACE FUNCTION `F_G_ID_PROJETO` (`PID_GRUPO` INT(11)) RETURNS INT(11) NO SQL
BEGIN
	
    DECLARE id_projeto INT;
    
    SELECT count(*) INTO id_projeto from projetos
    where id_grupo = PID_GRUPO;
    
    RETURN (id_projeto+1)+PID_GRUPO;
    
    
    
END$$

CREATE OR REPLACE FUNCTION `F_G_PK_GRUPOS` () RETURNS INT(11) NO SQL
BEGIN
    
	DECLARE pkg INT;	
	
	SELECT count(*) INTO pkg FROM grupos;
    
	RETURN (pkg+1)*1000;

END$$

CREATE OR REPLACE FUNCTION `f_horas_mes_atual` (`pid_funcionario` INTEGER) RETURNS DOUBLE BEGIN
    
	DECLARE mes_atual INT;
	DECLARE ano_atual INT;
	DECLARE media DOUBLE;	

	SET mes_atual := MONTH(SYSDATE());
	SET ano_atual := YEAR(SYSDATE());
	
	SELECT sum(nb_horas_trabalho) INTO media FROM horas_projetos_funcionarios 
	WHERE MONTH(dt_trabalho) = mes_atual 
	AND YEAR(dt_trabalho) = ano_atual
	AND id_funcionario = pid_funcionario;	

	RETURN media;

END$$

CREATE OR REPLACE FUNCTION `f_media_horas_3_meses` (`pid_funcionario` INTEGER) RETURNS DOUBLE BEGIN
    
	DECLARE mes_atual INT;
	DECLARE ano_atual INT;
	DECLARE media DOUBLE;	

	DECLARE x DOUBLE;
	DECLARE x2 DOUBLE;


	SET mes_atual := MONTH(SYSDATE());
	SET ano_atual := YEAR(SYSDATE());

	/* CASO COMUM */
	
	SELECT AVG((nb_horas_trabalho)) INTO media FROM horas_projetos_funcionarios
	WHERE MONTH(dt_trabalho) IN (mes_atual-1,mes_atual-2,mes_atual-3)
	AND YEAR(dt_trabalho) IN (ano_atual)
	AND id_funcionario = pid_funcionario;
	
	/* CASO ESPECIAL */
	IF(mes_atual = 3) THEN

		SELECT sum(nb_horas_trabalho) INTO x FROM horas_projetos_funcionarios 
		WHERE MONTH(dt_trabalho) IN (mes_atual-1,mes_atual-2) 
		AND YEAR(dt_trabalho) = ano_atual
		AND id_funcionario = pid_funcionario;

		SELECT sum(nb_horas_trabalho) INTO x2 FROM horas_projetos_funcionarios 
		WHERE MONTH(dt_trabalho) = 12 
		AND YEAR(dt_trabalho) = ano_atual-1
		AND id_funcionario = pid_funcionario;

		SET media := (x+x2)/3;
	END IF;

	IF(mes_atual = 2) THEN

		SELECT sum(nb_horas_trabalho) INTO x FROM horas_projetos_funcionarios
		WHERE MONTH(dt_trabalho) IN (mes_atual-1)
		AND YEAR(dt_trabalho) = ano_atual
		AND id_funcionario = pid_funcionario;
		
		SELECT sum(nb_horas_trabalho) INTO x2 FROM horas_projetos_funcionarios 
		WHERE MONTH(dt_trabalho) IN (11,12)
		AND YEAR(dt_trabalho) = ano_atual-1
		AND id_funcionario = pid_funcionario;

		SET media := (x+x2)/3;
	END IF;

	IF(mes_atual = 1) THEN

		SELECT sum(nb_horas_trabalho) INTO x FROM horas_projetos_funcionarios 
		WHERE MONTH(dt_trabalho) IN (10,11,12) 
		AND YEAR(dt_trabalho) = ano_atual-1
		AND id_funcionario = pid_funcionario;

		SET media := x/3;

	END IF;

	RETURN media;

END$$

CREATE OR REPLACE FUNCTION `f_media_horas_mes_anterior` (`pid_funcionario` INTEGER) RETURNS DOUBLE BEGIN
    
	DECLARE mes_atual INT;
	DECLARE ano_atual INT;
	DECLARE media DOUBLE;	

	SET mes_atual := MONTH(SYSDATE());
	SET ano_atual := YEAR(SYSDATE());

	IF(mes_atual = 1) THEN

		SELECT sum(nb_horas_trabalho) INTO media FROM horas_projetos_funcionarios 
		WHERE MONTH(dt_trabalho) IN (12) 
		AND YEAR(dt_trabalho) = ano_atual-1
		AND id_funcionario = pid_funcioncario;

	ELSE
	
		SELECT sum(nb_horas_trabalho) INTO media FROM horas_projetos_funcionarios 
		WHERE MONTH(dt_trabalho) = mes_atual-1 
		AND YEAR(dt_trabalho) = ano_atual
		AND id_funcionario = pid_funcionario;	

	END IF;

	RETURN media;

END$$

DELIMITER ;

CREATE TABLE `despesas_grupos` (
  `id_grupo` int(11) UNSIGNED NOT NULL,
  `dt_despesa` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `nb_despesa` double(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `empresas` (
  `id_empresa` int(11) NOT NULL,
  `tx_empresa` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `grupos` (
  `id_grupo` int(10) UNSIGNED NOT NULL,
  `tx_grupo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tx_color` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cs_situacao` char(1) COLLATE utf8mb4_unicode_ci DEFAULT '1' COMMENT '1 Ativo, 0 Desativado.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `grupos` (`id_grupo`, `tx_grupo`, `tx_color`, `created_at`, `updated_at`, `cs_situacao`) VALUES
(1000, 'ESTUDOS E PROJETOS', '#3acb83', '2018-05-03 01:32:01', '2018-05-03 01:32:01', '1'),
(2000, 'GERENCIAMENTO & FISCALIZAÇÃO', '#1da5d8', '2018-05-03 01:53:06', '2018-05-03 01:53:06', '1');


CREATE TABLE `horas_grupos` (
  `id_grupo` int(11) NOT NULL,
  `nb_horas` int(11) NOT NULL,
  `dt_horas` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `horas_projetos_funcionarios` (
  `id_funcionario` int(10) UNSIGNED NOT NULL,
  `id_projeto` int(10) UNSIGNED NOT NULL,
  `id_grupo` int(10) UNSIGNED NOT NULL,
  `dt_trabalho` date NOT NULL,
  `nb_horas_trabalho` int(11) NOT NULL,
  `nb_despesa` double(8,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cs_status_projeto` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cs_status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2017_12_06_214650_create_grupos_table', 1),
(2, '2014_10_12_000000_create_users_table', 2),
(3, '2014_10_12_100000_create_password_resets_table', 2),
(4, '2017_12_06_120308_create_projetos_table', 2),
(5, '2017_12_06_120739_create_projeto_funcionario_table', 3),
(6, '2017_12_06_121942_create_horas_projetos_funcionarios_table', 3);

CREATE TABLE `password_resets` (
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `projetos` (
  `id_projeto` int(10) UNSIGNED NOT NULL,
  `id_grupo` int(10) UNSIGNED NOT NULL,
  `tx_projeto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_empresa` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cs_situacao` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1 Ativo, 0 Desativado.',
  `cs_status` int(11) DEFAULT NULL COMMENT '0 - Investimento, 1 - Contratos, 2 - Favor'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `projetos_funcionarios` (
  `id_funcionario` int(10) UNSIGNED NOT NULL,
  `id_projeto` int(10) UNSIGNED NOT NULL,
  `id_grupo` int(10) UNSIGNED NOT NULL,
  `cs_situacao` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `users` (
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `tx_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tx_email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dt_admissao` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tx_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nb_category_user` int(11) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tx_funcao` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nb_nota` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id_usuario`, `tx_name`, `tx_email`, `dt_admissao`, `tx_password`, `nb_category_user`, `remember_token`, `created_at`, `updated_at`, `tx_funcao`, `nb_nota`) VALUES
(1, 'JOÃO AVELLAN', 'javellan@outlook.jp', '2018-03-18', '$2y$10$oVnoE2lGz4kt5EO0J7EEAO/2yro8Oa8OojCwgRjQi4yTFaD/RdCUC', 1, 'QgLoK5tTOlaa4JwT3KG01Vkgvme27gsXg2un24GeFlIoMlvc5hJ0AZZh7IcB', '2017-12-09 03:25:40', '2018-04-23 14:55:45', 'Database Administrator', 10),
(2, 'GABRIEL DE CASTRO', 'gabriel_castr@outlook.com.br', '2018-03-18', '$2y$10$U958ltlWFSPRntNYsH/4f.nA/rOK4GVSEzUxVvqhMSI5qVUS.yod.', 0, 'WiQ0xzKCBSgF6SJQJdi7KxdgE5SiEbP49pbc92fDtOEtiPL9qbQEefGkY305', '2017-12-23 16:39:40', '2018-04-23 14:55:23', 'Desenvolvedor', 5),
(3, 'KAZUO MORI', 'kazuo@poli.com.br', '2018-03-18', '$2y$10$cpJci2yP6.ubILd6.ugaa.wWaIKdmF6tbD8i31EKj/n4bquaz3CbC', 1, 'Z6i0Ie3zDCldWiLBbcA0dhBqy21zwFvB4qnZyMsGMGoJA7ZLibavilR9PMcx', '2017-12-23 16:39:40', '2018-03-18 14:14:29', NULL, NULL),
(4, 'VINICIUS', 'vinicius@politecnica-eng.com.br', '2018-03-18', '$2y$10$oKb/ZrMDNDOGedWjGZ09gOs.RAUlfFkWf2t/vVkf.N8mKxXga71u2', 1, 'WfV4qEXYI8tpl6elMsg4wGZ8tf6gLeu2SM2PAu3qb1v6qMjyanY5omSzarWj', '2017-12-23 16:39:40', '2018-03-18 14:14:31', NULL, NULL),
(5, 'YAGO SABINO VIEIRA', 'yagovsabino@gmail.com', '2018-03-18', '$2y$10$uRMXFC/Ebh47qZCXUWtcOuSyPMCbDvQelg25jS9bQj./cg5T3i1Um', 1, 'PKiaNOB1jzim8GcrZqnkB8hAZ4x08cgSyYcYI6KlW3yvRFY7N8eCUxA3O6GG', '2018-01-31 12:43:47', '2018-04-12 13:44:01', NULL, 0);


DROP TABLE IF EXISTS `v_funcionarios_gastos`;

CREATE OR REPLACE VIEW `v_funcionarios_gastos`  AS  select sum(`horas_projetos_funcionarios`.`nb_despesa`) AS `nb_gasto`,`users`.`tx_name` AS `tx_name` from (`horas_projetos_funcionarios` join `users`) where (`horas_projetos_funcionarios`.`id_funcionario` = `users`.`id_usuario`) group by `horas_projetos_funcionarios`.`id_funcionario`,`users`.`tx_name` order by sum(`horas_projetos_funcionarios`.`nb_despesa`) desc ;

DROP TABLE IF EXISTS `v_horas_trabalhadas`;

CREATE OR REPLACE VIEW `v_horas_trabalhadas`  AS  select `u`.`tx_name` AS `nome`,`p`.`tx_projeto` AS `projeto`,(case when (`p`.`cs_status` = 0) then 'INVESTIMENTO' when (`p`.`cs_status` = 1) then 'CONTRATO' when (`p`.`cs_status` = 2) then 'FAVOR' end) AS `status`,`h`.`nb_horas_trabalho` AS `hora`,`h`.`nb_despesa` AS `despesa`,date_format(`h`.`dt_trabalho`,'%M') AS `mes`,year(`h`.`dt_trabalho`) AS `ano`,date_format(`h`.`dt_trabalho`,'%d') AS `dia` from (((`horas_projetos_funcionarios` `h` join `projetos` `p`) join `users` `u`) join `grupos` `g`) where ((`h`.`id_projeto` = `p`.`id_projeto`) and (`h`.`id_grupo` = `p`.`id_grupo`) and (`p`.`id_grupo` = `g`.`id_grupo`) and (`h`.`id_funcionario` = `u`.`id_usuario`)) ;

DROP TABLE IF EXISTS `v_last_horas_projetos_funcionarios`;

CREATE OR REPLACE VIEW `v_last_horas_projetos_funcionarios`  AS  select `users`.`tx_name` AS `tx_name`,`projetos`.`tx_projeto` AS `tx_projeto`,`horas_projetos_funcionarios`.`nb_horas_trabalho` AS `nb_horas_trabalho`,date_format(`horas_projetos_funcionarios`.`dt_trabalho`,'%d/%m/%Y') AS `dt_trabalho`,date_format(`horas_projetos_funcionarios`.`created_at`,'%d/%m/%Y') AS `dt_created`,date_format(`horas_projetos_funcionarios`.`updated_at`,'%d/%m/%Y') AS `dt_updated`,`horas_projetos_funcionarios`.`nb_despesa` AS `nb_despesa` from ((`horas_projetos_funcionarios` join `users`) join `projetos`) where ((`horas_projetos_funcionarios`.`id_funcionario` = `users`.`id_usuario`) and (`horas_projetos_funcionarios`.`id_projeto` = `projetos`.`id_projeto`) and (`horas_projetos_funcionarios`.`id_grupo` = `projetos`.`id_grupo`)) order by `horas_projetos_funcionarios`.`updated_at` desc ;

DROP TABLE IF EXISTS `v_media_horas_funcionarios`;

CREATE OR REPLACE VIEW `v_media_horas_funcionarios`  AS  select ifnull(`f_media_horas_3_meses`(`users`.`id_usuario`),0) AS `meses`,ifnull(`f_media_horas_mes_anterior`(`users`.`id_usuario`),0) AS `anterior`,ifnull(`f_horas_mes_atual`(`users`.`id_usuario`),0) AS `atual`,`users`.`tx_name` AS `tx_name` from `users` ;

DROP TABLE IF EXISTS `v_projetos_gastos`;

CREATE OR REPLACE VIEW `v_projetos_gastos`  AS  select `projetos`.`tx_projeto` AS `tx_projeto`,sum(`horas_projetos_funcionarios`.`nb_despesa`) AS `nb_gasto` from (`horas_projetos_funcionarios` join `projetos`) where ((`horas_projetos_funcionarios`.`id_projeto` = `projetos`.`id_projeto`) and (`horas_projetos_funcionarios`.`id_grupo` = `projetos`.`id_grupo`)) group by `horas_projetos_funcionarios`.`id_projeto`,`projetos`.`tx_projeto` order by sum(`horas_projetos_funcionarios`.`nb_despesa`) desc ;

DROP TABLE IF EXISTS `v_resumo_mensal`;

CREATE OR REPLACE VIEW `v_resumo_mensal`  AS  select `horas_projetos_funcionarios`.`id_funcionario` AS `id_funcionario`,`grupos`.`tx_color` AS `tx_color`,`projetos`.`id_projeto` AS `id_projeto`,`projetos`.`tx_projeto` AS `tx_projeto`,date_format(`horas_projetos_funcionarios`.`dt_trabalho`,'%m/%Y') AS `dt_resumo`,sum(`horas_projetos_funcionarios`.`nb_horas_trabalho`) AS `nb_horas`,sum(`horas_projetos_funcionarios`.`nb_despesa`) AS `nb_despesas` from ((`horas_projetos_funcionarios` join `projetos`) join `grupos`) where ((`horas_projetos_funcionarios`.`id_projeto` = `projetos`.`id_projeto`) and (`horas_projetos_funcionarios`.`id_grupo` = `projetos`.`id_grupo`) and (`horas_projetos_funcionarios`.`id_grupo` = `grupos`.`id_grupo`)) group by `horas_projetos_funcionarios`.`id_funcionario`,`projetos`.`id_projeto`,`grupos`.`tx_color`,`projetos`.`tx_projeto`,date_format(`horas_projetos_funcionarios`.`dt_trabalho`,'%m/%Y') ;

ALTER TABLE `despesas_grupos`
  ADD PRIMARY KEY (`id_grupo`,`dt_despesa`);

ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id_empresa`);

ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id_grupo`);

ALTER TABLE `horas_grupos`
  ADD PRIMARY KEY (`id_grupo`,`dt_horas`);

ALTER TABLE `horas_projetos_funcionarios`
  ADD KEY `horas_projetos_funcionarios_id_funcionario_foreign` (`id_funcionario`),
  ADD KEY `horas_projetos_funcionarios_id_projeto_id_grupo_foreign` (`id_projeto`,`id_grupo`);

ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

ALTER TABLE `projetos`
  ADD PRIMARY KEY (`id_projeto`,`id_grupo`),
  ADD KEY `projetos_id_grupo_foreign` (`id_grupo`),
  ADD KEY `FK_PROJETOS_ID_EMPRESA` (`id_empresa`) USING BTREE;

ALTER TABLE `projetos_funcionarios`
  ADD PRIMARY KEY (`id_funcionario`,`id_projeto`,`id_grupo`),
  ADD KEY `projetos_funcionarios_id_projeto_id_grupo_foreign` (`id_projeto`,`id_grupo`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `users_tx_email_unique` (`tx_email`);

ALTER TABLE `empresas`
  MODIFY `id_empresa` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `users`
  MODIFY `id_usuario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `despesas_grupos`
  ADD CONSTRAINT `despesas_grupos_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id_grupo`);

ALTER TABLE `horas_projetos_funcionarios`
  ADD CONSTRAINT `horas_projetos_funcionarios_id_funcionario_foreign` FOREIGN KEY (`id_funcionario`) REFERENCES `users` (`id_usuario`),
  ADD CONSTRAINT `horas_projetos_funcionarios_id_projeto_id_grupo_foreign` FOREIGN KEY (`id_projeto`,`id_grupo`) REFERENCES `projetos` (`id_projeto`, `id_grupo`);

ALTER TABLE `projetos`
  ADD CONSTRAINT `FK_PROJETOS_ID_EMPRESA` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id_empresa`),
  ADD CONSTRAINT `projetos_id_grupo_foreign` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id_grupo`);

ALTER TABLE `projetos_funcionarios`
  ADD CONSTRAINT `projetos_funcionarios_id_funcionario_foreign` FOREIGN KEY (`id_funcionario`) REFERENCES `users` (`id_usuario`),
  ADD CONSTRAINT `projetos_funcionarios_id_projeto_id_grupo_foreign` FOREIGN KEY (`id_projeto`,`id_grupo`) REFERENCES `projetos` (`id_projeto`, `id_grupo`);
COMMIT;
