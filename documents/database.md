# Database Documentation
### Entities 👩‍👩‍👧‍👦
* User
* Wallet
* Transaction

### User Table 😎
- [x] id
- [x] name
- [x] email
- [x] password
- [x] cpf_cpnj
- [x] type ["common", "shopkeeper"]
- [x] created_at

### Wallet Table 💰
- [x] id
- [x] user_id
- [x] balance
- [x] status [active, inactive]
- [x] created_at
- [x] updated_at

### Log Wallet Table 💾
- [x] id
- [x] wallet_id
- [x] user_id
- [x] changed_field
- [x] old_value
- [x] new_value
- [x] created_at

### Transaction Table 💱
- [x] id
- [x] payer_id
- [x] payee_id
- [x] value
- [x] status [approved, not-approved, canceled]
- [x] created_at
- [x] updated_at

### Log Transaction Table 💾
- [x] id
- [x] transaction_id
- [x] user_id
- [x] changed_field
- [x] old_value
- [x] new_value
- [x] created_at