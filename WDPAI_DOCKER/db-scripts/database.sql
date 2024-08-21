DROP TABLE IF EXISTS tickets;
DROP TABLE IF EXISTS providers;
DROP TABLE IF EXISTS locations;
DROP TABLE IF EXISTS transport_types;
DROP TABLE IF EXISTS ticket_types;
DROP TABLE IF EXISTS users;
DROP TYPE IF EXISTS userrole;

CREATE TYPE userrole AS ENUM ('USER', 'ADMIN');

CREATE TABLE users (
	user_id SERIAL PRIMARY KEY,
	user_name TEXT NOT NULL,
	user_email TEXT NOT NULL,
	user_password TEXT NOT NULL,
	user_role userrole NOT NULL DEFAULT 'USER'
);

CREATE TABLE user_sessions (
	user_id INT PRIMARY KEY,
	session_id TEXT NOT NULL,
	CONSTRAINT user_sessions_fk_user_id 
		FOREIGN KEY (user_id) 
			REFERENCES users(user_id)
);

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
	ticket_type_name TEXT NOT NULL
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

INSERT INTO users (user_name, user_password, user_email)
VALUES ('aaaaa', 'aaaaa', 'aaaaa@example.com'),
('bbbbb', 'bbbbb', 'bbbbb@example.com'),
('ccccc', 'ccccc', 'ccccc@example.com');

INSERT INTO providers (provider_name)
VALUES ('moBiLET'), ('MPK'), ('MPAY');

INSERT INTO locations (location_name)
VALUES ('Cracow'), ('Warsaw'), ('Wroclaw');

INSERT INTO transport_types (transport_type_name)
VALUES ('Bus'), ('Tram'), ('Train');

INSERT INTO ticket_types (ticket_type_name)
VALUES ('20 Min'), ('60 Min'), ('Day Pass'), ('Week Pass');

INSERT INTO tickets (user_id, provider_id, location_id, transport_type_id, ticket_type_id) 
VALUES (1, 1, 1, 1, 1), (2, 2, 2, 2, 2), (3, 3, 3, 3, 4);