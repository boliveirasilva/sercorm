-- =============================== oracle11.2_XE =============================== --

-- alterando schema ativo
alter session set current_schema = sercorm;

-- Cria uma tabela USERS
CREATE TABLE tb_users (
    id              NUMBER(18)      PRIMARY KEY,
    first_name      VARCHAR(40)     NOT NULL,
    last_name       VARCHAR(60),
    email           VARCHAR(120)    UNIQUE,
    username        VARCHAR(50)     UNIQUE NOT NULL,
    password        VARCHAR(255),
    update_date     TIMESTAMP,
    phone           VARCHAR(20),
    created_at      TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP       DEFAULT CURRENT_TIMESTAMP
);

-- Cria um sequence para gerar o id
CREATE SEQUENCE gen_users_sequence
    MINVALUE 1
    MAXVALUE 9999999999999999999
    START WITH 1
    INCREMENT BY 1
    NOCACHE;

-- Cria um trigger para automatizar a geração de id
CREATE OR REPLACE TRIGGER tr_users_id
    BEFORE INSERT ON tb_users
    FOR EACH ROW
begin
    if(:new.id is null)then
        :new.id := gen_users_sequence.nextval;
    end if;
end;
/