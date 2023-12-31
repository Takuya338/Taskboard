#!/bin/bash

# 目的のディレクトリに移動
if [ "$(pwd)" != "/home/bitnami/taskboard" ]; then
  cd /home/bitnami/taskboard || exit
fi

# devブランチに移動
git checkout dev

# taskboardフォルダをgitに追加
git add taskboard

# コマンドライン引数が空の場合は現在の日時をメッセージとする
commit_message=$1
if [ -z "$commit_message" ]; then
  commit_message=$(date +"%Y/%m/%d %H:%M:%S 改修")
fi
git commit -m "$commit_message"

# devブランチにプッシュ
git push origin dev
