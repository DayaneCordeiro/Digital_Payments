<?php

/**
 * @api {put} /transactions_cancel_by_user  User cancel transaction
 * 
 * @apiHeader{json} Header {"Content-Type": "application/json"}
 * 
 * @apiName CancelByUser
 * @apiGroup Transactions
 *
 * @apiParam {Number} user_id User unique ID.
 * @apiParam {Number} id      Transaction unique ID.
 * 
 * @apiSuccessExample Request Example:
 *    {
 *        "user_id" : 1,
 *        "id" : 8
 *    }
 */

 /**
 * @api {put} /transactions_cancel  Cancel transaction
 * 
 * @apiHeader{json} Header {"Content-Type": "application/json"}
 * 
 * @apiName Cancel
 * @apiGroup Transactions
 *
 * @apiParam {Number} id      Transaction unique ID.
 * 
 * @apiSuccessExample Request Example:
 *    {
 *        "id" : 8
 *    }
 */

 /**
 * @api {get} /transactions:id  Get transaction by id
 * 
 * @apiHeader{json} Header {"Content-Type": "application/json"}
 * 
 * @apiName GetTransactionById
 * @apiGroup Transactions
 *
 * @apiParam {Number} id    Transaction unique ID.
 *
 * @apiSuccess {Response} Transaction      Request return.
 * 
 * @apiSuccessExample Return Example:
 *    {
 *        "id": 1,
 *        "payer_id": 1,
 *        "payee_id": 2,
 *        "value": 15000,
 *        "status": "approved",
 *        "created_at": "2021-11-02T04:13:42.000000Z",
 *        "updated_at": "2021-11-02T04:13:42.000000Z"
 *    }
 */

 /**
 * @api {post} /transactions Create new transaction
 * 
 * @apiHeader{json} Header {"Content-Type": "application/json"}
 * 
 * @apiName Createtransaction
 * @apiGroup Transactions
 * 
 * @apiParam {Number} payer_id  Unique identification of the User who is paying.
 * @apiParam {Number} payee_id  Unique identification of the User who is receiving money.
 * @apiParam {Number} value     Value of the transaction.
 * @apiParam {String} password  Password of the payer user.
 * 
 * @apiSuccess {Json} Transaction      Request return.
 *
 * @apiSuccessExample Request Example:
 *    {
 *        "payer_id": 1,
 *        "payee_id": 2,
 *        "value": 5000,
 *        "password": "1015466"
 *    }
 * 
 * @apiSuccessExample Return Example:
 *    {
 *       "payer_id": 1,
 *       "payee_id": 2,
 *       "value": 5000,
 *       "status": "approved",
 *       "updated_at": "2021-11-03T03:43:08.000000Z",
 *       "created_at": "2021-11-03T03:43:08.000000Z",
 *       "id": 8
 *    }
 */