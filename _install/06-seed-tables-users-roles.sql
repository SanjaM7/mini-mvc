INSERT INTO `mini` . roles (id, role) VALUES (1,'DJ'),(2,'Admin'),(3,'Blocked');

INSERT INTO `mini` . users (username,email,hashedPassword,role_id) values ('Dj','dj@dj.com','$2y$10$hvtHvaKkh8FSPfjYCE0mJ.aRSVl.mdin13oZt.N6xR1k4SqT075bm', 1);
INSERT INTO `mini` . users (username,email,hashedPassword,role_id) values ('Admin','admin@admin.com','$2y$10$rJuLu1LbxCtB.dyOq3bEz.WDMCsEoIJqSdXQ3YBucqPdmViUlZCje', 2);

