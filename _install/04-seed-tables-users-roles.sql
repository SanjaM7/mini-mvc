SET GLOBAL FOREIGN_KEY_CHECKS=0;

INSERT INTO `mini` . roles (id, role) VALUES (1,'DJ'),(2,'Admin'),(3,'Blocked');

INSERT INTO `mini` . users (username,email,hashedPassword,role_id) values ('Dj','dj@dj.com','$2y$10$XkY0zXBjCnkmzdIg3iRsoe9UoL1F/DOe3mr5CJkleatnUqVLpZal2', 1);
INSERT INTO `mini` . users (username,email,hashedPassword,role_id) values ('Dj2','dj@dj2.com','$2y$10$XkY0zXBjCnkmzdIg3iRsoe9UoL1F/DOe3mr5CJkleatnUqVLpZal2', 1);
INSERT INTO `mini` . users (username,email,hashedPassword,role_id) values ('Dj3','dj@dj3.com','$2y$10$XkY0zXBjCnkmzdIg3iRsoe9UoL1F/DOe3mr5CJkleatnUqVLpZal2', 1);
INSERT INTO `mini` . users (username,email,hashedPassword,role_id) values ('Admin','admin@admin.com','$2y$10$XkY0zXBjCnkmzdIg3iRsoe9UoL1F/DOe3mr5CJkleatnUqVLpZal2', 2);

