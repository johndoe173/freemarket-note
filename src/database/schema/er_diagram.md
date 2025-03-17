```mermaid
erDiagram

    USERS {
        INT id
        STRING name
        STRING email
        STRING zipcode
        STRING address
        STRING building
        DATETIME email_verified_at
        STRING password
        STRING profile_image
        STRING two_factor_secret
        STRING two_factor_recovery_codes
        DATETIME two_factor_confirmed_at
        STRING remember_token
        DATETIME created_at
        DATETIME updated_at
    }

    PRODUCTS {
        INT id
        STRING name
        TEXT description
        DECIMAL price
        STRING condition
        STRING category
        STRING image
        INT user_id
        BOOLEAN is_sold
        DATETIME created_at
        DATETIME updated_at
    }

    CATEGORIES {
        INT id
        STRING name
        DATETIME created_at
        DATETIME updated_at
    }

    CATEGORY_PRODUCT {
        INT id
        INT product_id
        INT category_id
        DATETIME created_at
        DATETIME updated_at
    }

    COMMENTS {
        INT id
        INT user_id
        INT product_id
        TEXT content
        DATETIME created_at
        DATETIME updated_at
    }

    LIKES {
        INT id
        INT user_id
        INT product_id
        DATETIME created_at
        DATETIME updated_at
    }

    PURCHASES {
        INT id
        INT user_id
        INT product_id
        DATETIME purchase_date
        DATETIME created_at
        DATETIME updated_at
    }

    USERS ||--o{ PRODUCTS : "出品"
    USERS ||--o{ PURCHASES : "購入"
    USERS ||--o{ LIKES : "いいね"
    USERS ||--o{ COMMENTS : "コメント"

    PRODUCTS ||--o{ CATEGORY_PRODUCT : "カテゴリ設定"
    PRODUCTS ||--o{ COMMENTS : "コメント"
    PRODUCTS ||--o{ LIKES : "いいね"
    PRODUCTS ||--o{ PURCHASES : "購入"

    CATEGORIES ||--o{ CATEGORY_PRODUCT : "カテゴリ設定"

