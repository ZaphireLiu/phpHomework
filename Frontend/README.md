# README

> 前台网站

## 数据库

### 用户数据：user_account

### 新闻数据：news_data

| 名字         | 类型        | 排序规则           | 空   | 默认                            | 注释            |
| ------------ | ----------- | ------------------ | ---- | ------------------------------- | --------------- |
| id           | int         | utf8_bin           | 否   |                                 | 新闻id          |
| title        | varchar(64) | utf8mb4_general_ci | 否   |                                 | 标题            |
| publish_time | timestamp   |                    | 否   | on update = current_timestamp() | 发布时间        |
| info         | varchar(64) | utf8mb4_general_ci | 是   |                                 | 小标题/发布信息 |

## 文件夹结构