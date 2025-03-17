```mermaid
erDiagram
    USERS {
        BIGINT id
        VARCHAR name
        VARCHAR email
        VARCHAR zipcode
        TEXT address
        TEXT building
        TIMESTAMP email_verified_at
        VARCHAR password
        VARCHAR profile_image
        VARCHAR remember_token
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    PRODUCTS {
        BIGINT id
        BIGINT user_id
        VARCHAR name
        TEXT description
        DECIMAL price
        ENUM condition
        VARCHAR image
        BOOLEAN is_sold
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    CATEGORIES {
        BIGINT id
        VARCHAR name
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    CATEGORY_PRODUCT {
        BIGINT id
        BIGINT product_id
        BIGINT category_id
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    COMMENTS {
        BIGINT id
        BIGINT user_id
        BIGINT product_id
        TEXT content
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    LIKES {
        BIGINT id
        BIGINT user_id
        BIGINT product_id
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    PURCHASES {
        BIGINT id
        BIGINT user_id
        BIGINT product_id
        TIMESTAMP purchase_date
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    %% テーブル間のリレーションシップ
    USERS ||--o{ PRODUCTS : "出品"
    USERS ||--o{ COMMENTS : "コメント"
    USERS ||--o{ LIKES : "いいね"
    USERS ||--o{ PURCHASES : "購入"
    PRODUCTS ||--o{ CATEGORY_PRODUCT : "カテゴリ設定"
    CATEGORIES ||--o{ CATEGORY_PRODUCT : "カテゴリ設定"
    PRODUCTS ||--o{ COMMENTS : "コメント"
    PRODUCTS ||--o{ LIKES : "いいね"
    PRODUCTS ||--o{ PURCHASES : "購入"
