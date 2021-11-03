<?php

/**
 * @api {post} /wallets_deposite  Insert money into wallet.
 * 
 * @apiHeader{json} Header {"Content-Type": "application/json"}
 * 
 * @apiName WalletDeposite
 * @apiVersion 1.0.0
 * @apiGroup Wallets
 *
 * @apiParam {Number} id      Wallet unique ID.
 * @apiParam {Number} value   Money quantity.
 *
 * @apiSuccess {Response} Wallet      Request return.
 * 
 * @apiSuccessExample Request Example:
 *    {
 *        "id" : 1,
 *        "value" : 12000
 *    }
 * 
 * @apiSuccessExample Return Example:
 *    {
 *        "id": 1,
 *        "user_id": 1,
 *        "balance": 23000,
 *        "status": "active",
 *        "created_at": "2021-11-02T03:50:17.000000Z",
 *        "updated_at": "2021-11-03T04:03:57.000000Z"
 *    }
 */

 /**
 * @api {get} /wallets:id  Get wallet by id
 * 
 * @apiHeader{json} Header {"Content-Type": "application/json"}
 * 
 * @apiName GetWalletById
 * @apiVersion 1.0.0
 * @apiGroup Wallets
 *
 * @apiParam {Number} id    Wallets unique ID.
 *
 * @apiSuccess {Response} Wallet      Request return.
 * 
 * @apiSuccessExample Return Example:
 *    {
 *        "id": 1,
 *        "user_id": 1,
 *        "balance": 45000,
 *        "status": "active",
 *        "created_at": "2021-11-02T03:50:17.000000Z",
 *        "updated_at": "2021-11-02T04:08:13.000000Z"
 *    }
 */

 /**
 * @api {post} /wallets Create new wallet
 * 
 * @apiHeader{json} Header {"Content-Type": "application/json"}
 * 
 * @apiName CreateWallet
 * @apiGroup Wallets
 * 
 * @apiParam {Number} user_id   Unique identification of the User.
 * @apiParam {Number} balance   Balance of the wallet.
 * @apiParam {String} status    Status pf the wallet.
 * 
 * @apiSuccess {Json} Wallet      Request return.
 *
 * @apiSuccessExample Request Example:
 *    {
 *        "user_id": 2,
 *        "balance": 50000.00,
 *        "status": "active"
 *    }
 * 
 * @apiSuccessExample Return Example:
 *    {
 *       "user_id": 2,
 *       "balance": 50000,
 *       "status": "active",
 *       "updated_at": "2021-11-02T22:42:11.000000Z",
 *    }
 */

  /**
 * @api {put} /wallets_active Active Wallet
 * 
 * @apiHeader{json} Header {"Content-Type": "application/json"}
 * 
 * @apiName WalletActiveS
 * @apiGroup Wallets
 *
 * @apiParam {Number} id     Id of the User. 
 * 
 * @apiSuccessExample Request Example:
 *    {
 *        "id"    :   "1"
 *    }
 *
 */

   /**
 * @api {put} /wallets_inactive Inactive wallet
 * 
 * @apiHeader{json} Header {"Content-Type": "application/json"}
 * 
 * @apiName WalletInactive
 * @apiGroup Wallets
 *
 * @apiParam {Number} id     Id of the User. 
 * 
 * @apiSuccessExample Request Example:
 *    {
 *        "id"    :   "1"
 *    }
 */