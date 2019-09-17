CREATE TABLE invitations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    guest_name VARCHAR(191) NOT NULL,
    inviter_name VARCHAR(191) NOT NULL,
    address_one VARCHAR(191) NOT NULL,
    address_two VARCHAR(191) NOT NULL DEFAULT '',
    town VARCHAR(191) NOT NULL,
    county VARCHAR(191) NOT NULL DEFAULT '',
    postcode VARCHAR(11) NOT NULL,
    email VARCHAR(255) NOT NULL,
    user_agent VARCHAR(191) NULL
);
