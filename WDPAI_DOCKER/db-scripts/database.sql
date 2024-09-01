DROP TABLE IF EXISTS tickets_to_buy;
DROP TABLE IF EXISTS intervals;

DROP TABLE IF EXISTS tickets;
DROP TABLE IF EXISTS providers;
DROP TABLE IF EXISTS locations;
DROP TABLE IF EXISTS transport_types;
DROP TABLE IF EXISTS ticket_types;
DROP TABLE IF EXISTS user_sessions_archive;
DROP TABLE IF EXISTS user_sessions;
DROP TABLE IF EXISTS users;
DROP TYPE IF EXISTS userrole;

CREATE TYPE userrole AS ENUM ('USER', 'ADMIN');

CREATE TABLE users (
	user_id SERIAL PRIMARY KEY,
	user_name TEXT NOT NULL,
	user_email TEXT NOT NULL UNIQUE,
	user_password TEXT NOT NULL,
	user_role userrole NOT NULL DEFAULT 'USER'
);

CREATE TABLE user_sessions (
	user_id INT PRIMARY KEY,
	session_id UUID UNIQUE NOT NULL DEFAULT gen_random_uuid(),
	create_time TIMESTAMP NOT NULL DEFAULT now(),
	CONSTRAINT user_sessions_fk_user_id 
		FOREIGN KEY (user_id) 
			REFERENCES users(user_id)
);

CREATE TABLE user_sessions_archive (
    user_id INT,
    session_id UUID,
	logged_in_time TIMESTAMP NOT NULL,
    logged_out_time TIMESTAMP NOT NULL
);

CREATE OR REPLACE FUNCTION archive_user_session() 
RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO user_sessions_archive (user_id, session_id, logged_in_time, logged_out_time)
    VALUES (OLD.user_id, OLD.session_id, OLD.create_time, now());

	RETURN OLD;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE TRIGGER user_sessions_archive_trigger_on_delete
AFTER DELETE ON user_sessions
FOR EACH ROW
EXECUTE FUNCTION archive_user_session();

CREATE TABLE providers (
	provider_id SERIAL PRIMARY KEY,
	provider_name TEXT NOT NULL
);

CREATE TABLE locations (
	location_id SERIAL PRIMARY KEY,
	location_name TEXT NOT NULL
);

CREATE TABLE transport_types (
	transport_type_id SERIAL PRIMARY KEY,
	transport_type_name TEXT NOT NULL
);

CREATE TABLE ticket_types (
	ticket_type_id SERIAL PRIMARY KEY,
	ticket_type_name TEXT NOT NULL,
	ticket_type_expiry_interval INTERVAL NOT NULL
);

CREATE TABLE tickets (
	ticket_id SERIAL PRIMARY KEY,
	user_id INT NOT NULL,
	provider_id INT NOT NULL,
	location_id INT NOT NULL,
	transport_type_id INT NOT NULL,
	ticket_type_id INT NOT NULL,
	expiry_time TIMESTAMP NOT NULL DEFAULT now() + INTERVAL '14 DAYS',
	purchase_time TIMESTAMP NOT NULL DEFAULT now(),
	CONSTRAINT tickets_fk_user_id 
		FOREIGN KEY (user_id) 
			REFERENCES users(user_id),
	CONSTRAINT tickets_fk_provider_id 
		FOREIGN KEY (provider_id) 
			REFERENCES providers(provider_id),
	CONSTRAINT tickets_fk_location_id 
		FOREIGN KEY (location_id) 
			REFERENCES locations(location_id),
	CONSTRAINT tickets_fk_transport_id 
		FOREIGN KEY (transport_type_id) 
			REFERENCES transport_types(transport_type_id),
	CONSTRAINT tickets_fk_ticket_type_id 
		FOREIGN KEY (ticket_type_id) 
			REFERENCES ticket_types(ticket_type_id)
	
);

CREATE TABLE intervals (
	interval_id SERIAL PRIMARY KEY,
	interval_name TEXT UNIQUE NOT NULL
);

CREATE TABLE tickets_to_buy (
	ticket_to_buy_id SERIAL PRIMARY KEY,
	provider_id INT NOT NULL,
	location_id INT NOT NULL,
	transport_type_id INT NOT NULL,
	ticket_type_id INT NOT NULL,
	CONSTRAINT tickets_to_buy_fk_provider_id 
		FOREIGN KEY (provider_id) 
			REFERENCES providers(provider_id),
	CONSTRAINT tickets_to_buy_fk_location_id 
		FOREIGN KEY (location_id) 
			REFERENCES locations(location_id),
	CONSTRAINT tickets_to_buy_fk_transport_id 
		FOREIGN KEY (transport_type_id) 
			REFERENCES transport_types(transport_type_id),
	CONSTRAINT tickets_to_buy_fk_ticket_type_id 
		FOREIGN KEY (ticket_type_id) 
			REFERENCES ticket_types(ticket_type_id),
	UNIQUE(provider_id, location_id, transport_type_id, ticket_type_id)
);

INSERT INTO users (user_name, user_password, user_email, user_role)
VALUES ('aaaaa', 'aaaaa', 'aaaaa@example.com', 'USER'),
('bbbbb', 'bbbbb', 'bbbbb@example.com', 'USER'),
('ccccc', 'ccccc', 'ccccc@example.com', 'USER'),
('user', 'user', 'user@example.com', 'USER'),
('admin', 'admin', 'admin@example.com', 'ADMIN');

INSERT INTO providers (provider_name)
VALUES ('moBiLET'), ('MPK'), ('MPAY');

INSERT INTO locations (location_name)
VALUES ('Cracow'), ('Warsaw'), ('Wroclaw');

INSERT INTO transport_types (transport_type_name)
VALUES ('Bus'), ('Tram'), ('Train'), ('Subway');

INSERT INTO ticket_types (ticket_type_name, ticket_type_expiry_interval)
VALUES ('20 Min', '20 MINUTES'), ('1 HOUR', '1 HOUR'), ('Day Pass', '1 DAY'), ('Week Pass', '1 WEEK');

INSERT INTO tickets (user_id, provider_id, location_id, transport_type_id, ticket_type_id) 
VALUES (1, 1, 1, 1, 1), (2, 2, 2, 2, 2), (3, 3, 3, 3, 4);

INSERT INTO intervals (interval_name)
VALUES ('MINUTES'), ('HOURS'), ('DAYS'), ('WEEKS'), ('MONTHS'), ('YEARS');

INSERT INTO tickets_to_buy (provider_id, location_id, transport_type_id, ticket_type_id)
VALUES 
(2, 1, 1, 1),
(2, 1, 1, 2),
(2, 1, 1, 3),
(2, 1, 1, 4),

(2, 1, 2, 1),
(2, 1, 2, 2),
(2, 1, 2, 3),
(2, 1, 2, 4),

(2, 1, 3, 3),
(2, 1, 3, 4),

(3, 2, 1, 1),
(3, 2, 1, 2),
(3, 2, 1, 3),
(3, 2, 1, 4),

(3, 1, 2, 1),
(3, 1, 2, 2),
(3, 1, 2, 3),
(3, 1, 2, 4),

(3, 1, 3, 3),
(3, 1, 3, 4),

(3, 1, 4, 1),
(3, 1, 4, 2),
(3, 1, 4, 3),
(3, 1, 4, 4);
