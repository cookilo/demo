### Common way

.env.exampleを .envに変更してから、 .envファイルでのいくつか情報を変更いたします。

    APP_URL=あなたのローカルドメイン
    MIX_APP_URL=あなたのローカルドメイン

データベース情報

    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=user_management
    DB_USERNAME=root
    DB_PASSWORD=

次は以下を実行します。

PHP と JavaScript の依存関係をインストールします。

    ccomposer install
    npm install

Generate Laravel keys:

    php artisan key:generate

データベースを移行してシードします。

    php artisan migrate --seed

すべてのフロントエンドスタッフをコンパイルします:

    npm run dev

アカウントのデフォルト:

    ユーザー: admin@admin.com
    パスワード: 123456
