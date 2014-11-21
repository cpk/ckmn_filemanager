ALTER TABLE `roles` ADD `actived` INT(11) NULL AFTER `description`;
ALTER TABLE `permissions` CHANGE `status` `actived` INT(11) NULL DEFAULT NULL;
UPDATE `demo_alpha`.`roles` SET `actived` = '1' 

INSERT INTO `demo_alpha`.`permissions` (`id`, `name`, `description`, `section`, `module`, `actived`, `created`, `modified`) VALUES (NULL, 'roles.show', '', 'role', 'show', 1, '', '');
INSERT INTO `demo_alpha`.`permissions` (`id`, `name`, `description`, `section`, `module`, `actived`, `created`, `modified`) VALUES (NULL, 'roles.edit', '', 'role', 'edit', 1, '', '');
INSERT INTO `demo_alpha`.`permissions` (`id`, `name`, `description`, `section`, `module`, `actived`, `created`, `modified`) VALUES (NULL, 'roles.update', '', 'role', 'update', 1, '', '');
INSERT INTO `demo_alpha`.`permissions` (`id`, `name`, `description`, `section`, `module`, `actived`, `created`, `modified`) VALUES (NULL, 'roles.delete', '', 'role', 'delete', 1, '', '');
INSERT INTO `demo_alpha`.`permissions` (`id`, `name`, `description`, `section`, `module`, `actived`, `created`, `modified`) VALUES (NULL, 'roles.add', '', 'role', 'add', 1, '', '');
INSERT INTO `demo_alpha`.`permissions` (`id`, `name`, `description`, `section`, `module`, `actived`, `created`, `modified`) VALUES (NULL, 'roles.create', NULL, 'role', 'create', '1', '', '');

INSERT INTO `demo_alpha`.`roles_permissions` (`id`, `role_id`, `permission_id`, `created`, `modified`) VALUES (NULL, '1', '8', '', '');
INSERT INTO `demo_alpha`.`roles_permissions` (`id`, `role_id`, `permission_id`, `created`, `modified`) VALUES (NULL, '1', '9', '', '');
INSERT INTO `demo_alpha`.`roles_permissions` (`id`, `role_id`, `permission_id`, `created`, `modified`) VALUES (NULL, '1', '10', '', '');
INSERT INTO `demo_alpha`.`roles_permissions` (`id`, `role_id`, `permission_id`, `created`, `modified`) VALUES (NULL, '1', '11', '', '');
INSERT INTO `demo_alpha`.`roles_permissions` (`id`, `role_id`, `permission_id`, `created`, `modified`) VALUES (NULL, '1', '12', '', '');
INSERT INTO `demo_alpha`.`roles_permissions` (`id`, `role_id`, `permission_id`, `created`, `modified`) VALUES (NULL, '1', '13', '', '');
