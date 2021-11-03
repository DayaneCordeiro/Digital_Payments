<?php

/**
 * @api {get} /users:id  Get user by id
 * 
 * @apiHeader{json} Header {"Content-Type": "application/json"}
 * 
 * @apiName GetUserById
 * @apiVersion 1.0.0
 * @apiGroup Users
 *
 * @apiParam {Number} id    Users unique ID.
 *
 * @apiSuccess {Response} User      Request return.
 * 
 * @apiSuccessExample Return Example:
 *    {
 *        "id": 1,
 *        "name": "Dayane Cordeiro",
 *        "email": "dayane.cordeirogs@gmail.com",
 *        "password": "e10adc3949ba59abbe56e057f20f883e",
 *        "cpf_cnpj": "12648654602",
 *        "type": "common",
 *        "status": "active",
 *        "created_at": "2021-11-02T03:00:10.000000Z",
 *        "updated_at": "2021-11-02T21:34:50.000000Z"
 *    }
 */

 /**
 * @api {post} /users Create new user
 * 
 * @apiHeader{json} Header {"Content-Type": "application/json"}
 * 
 * @apiName CreateUser
 * @apiGroup Users
 * 
 * @apiParam {String} name      Name of the User.
 * @apiParam {String} email     Email of the User.
 * @apiParam {String} cpf_cnpj  CPF ou CNPJ of the User.
 * @apiParam {String} type      Type of the User.
 * @apiParam {String} status    Status pf the user.
 * @apiParam {String} password  Password of the User. 
 * 
 * @apiSuccess {String} status      Request return.
 *
 * @apiSuccessExample Request Example:
 *    {
 *        "name": "Jorge Gabriel das Neves",
 *        "email": "jorgegabrieldasneves_@azulcargo.com.br",
 *        "cpf_cnpj": "18833759750",
 *        "type": "common",
 *        "status": "active",
 *        "password": "8f5cCp3up8"
 *    }
 * 
 * @apiSuccessExample Return Example:
 *    {
 *       "name": "Jorge Gabriel das Neves",
 *       "email": "jorgegabrieldasneves_@azulcargo.com.br",
 *       "password": "$2y$10$NbbAFgDG7TjSF6U.LCD\/QOQRWDnSkEyxwKgwfJ4TWijg7G\/4BFN4S",
 *       "cpf_cnpj": "18833759750",
 *       "type": "common",
 *       "status": "active",
 *       "updated_at": "2021-11-02T22:42:11.000000Z",
 *       "created_at": "2021-11-02T22:42:11.000000Z",
 *       "id": 25
 *    }
 */

  /**
 * @api {put} /users/ Updates user
 * 
 * @apiHeader{json} Header {"Content-Type": "application/json"}
 * 
 * @apiName UpdatesUser
 * @apiGroup Users
 *
 * @apiParam {String} name      Name of the User.
 * @apiParam {String} email     Email of the User.
 * @apiParam {String} password  Password of the User.
 * @apiParam {String} cpf_cnpj  CPF or CNPJ of the User.
 * @apiParam {String} type      Type of the User.
 *
 * @apiSuccess {String} status      Request return.
 * 
 * @apiSuccessExample Request Example:
 *    {
 *        "name": "Jorge Gabriel das Neves",
 *        "email": "jorgegabrieldasneves_@azulcargo.com.br",
 *        "password": "8f5cCp3up8"
 *        "cpf_cnpj": "18833759750",
 *        "type": "common"
 *    }
 * 
 * @apiSuccessExample Return Example:
 *    {
 *       "id": 25
 *       "name": "Jorge Gabriel das Neves",
 *       "email": "jorgegabrieldasneves_@azulcargo.com.br",
 *       "password": "$2y$10$NbbAFgDG7TjSF6U.LCD\/QOQRWDnSkEyxwKgwfJ4TWijg7G\/4BFN4S",
 *       "cpf_cnpj": "18833759750",
 *       "type": "common",
 *       "status": "active",
 *       "created_at": "2021-11-02T22:42:11.000000Z",
 *       "updated_at": "2021-11-02T22:42:11.000000Z",
 *    }
 */

  /**
 * @api {put} /users_active Active user
 * 
 * @apiHeader{json} Header {"Content-Type": "application/json"}
 * 
 * @apiName UserActive
 * @apiGroup Users
 *
 * @apiParam {Number} id     Id of the User. 
 *
 * 
 * @apiSuccessExample Request Example:
 *    {
 *        "id"    :   "1"
 *    }
 */

   /**
 * @api {put} /users_inactive Inactive user
 * 
 * @apiHeader{json} Header {"Content-Type": "application/json"}
 * 
 * @apiName UserInactive
 * @apiGroup Users
 *
 * @apiParam {Number} id     Id of the User. 
 * 
 * @apiSuccessExample Request Example:
 *    {
 *        "id"    :   "1"
 *    }
 */