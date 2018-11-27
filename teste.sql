BEGIN
    
	DECLARE mes_atual INT;
	DECLARE ano_atual INT;
	DECLARE mes_get INT;
	DECLARE ano_get INT;    
	DECLARE media DOUBLE;	

	DECLARE x DOUBLE;
	DECLARE x2 DOUBLE;

	SET mes_atual := MONTH(SYSDATE());
	SET ano_atual := YEAR(SYSDATE());

	/* CASO COMUM !ERRADO! ESTAVA SELECIONANDO A MEDIA DAS HORAS DIARIAS*/

    SET mes_get := mes_atual - 12;

    IF mes_get < 0 THEN
        
        /*tiro o negativo do mês*/
        SET mes_get := mes_get * (-1);
        
        /*e vejo exatamente qual é o mes*/        
        SET mes_get := 12 - mes_get;
        SET ano_get := ano_atual - 1;

		SELECT sum(nb_horas_trabalho) INTO x FROM horas_projetos_funcionarios 
		WHERE MONTH(dt_trabalho) <= mes_atual
		AND YEAR(dt_trabalho) = ano_atual
		AND id_funcionario = pid_funcionario;

		SELECT sum(nb_horas_trabalho) INTO x2 FROM horas_projetos_funcionarios 
		WHERE MONTH(dt_trabalho) >= mes_get 
		AND YEAR(dt_trabalho) = ano_get
		AND id_funcionario = pid_funcionario;

        SET media := (x+x2)/12;
    ELSE

    	SELECT sum(nb_horas_trabalho) INTO x FROM horas_projetos_funcionarios 
		WHERE MONTH(dt_trabalho) <= mes_atual
		AND YEAR(dt_trabalho) = ano_atual
		AND id_funcionario = pid_funcionario;

        SET media := (x)/12;

    END IF;

	RETURN ROUND(media, 1);

END