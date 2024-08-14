DROP TABLE IF EXISTS tickets;

CREATE TABLE tickets (
	ticket_id SERIAL PRIMARY KEY,
	user_id TEXT NOT NULL,
	provider_id TEXT NOT NULL,
	location_id TEXT NOT NULL,
	transport_id TEXT NOT NULL,
	ticket_type_id TEXT NOT NULL,
	expiry_time TIMESTAMP DEFAULT now() + INTERVAL '14 DAYS',
	purchase_time TIMESTAMP DEFAULT now()
);

INSERT INTO tickets (
	user_id, 
	provider_id, 
	location_id, 
	transport_id, 
	ticket_type_id) 
VALUES (
	'USER_ID_1', 
	'PROVIDER_ID_1', 
	'LOCATION_ID_1', 
	'TRANSPORT_ID_1', 
	'TICKET_TYPE_ID_1');