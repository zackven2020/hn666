#10.7
##### 新增数据表
* game_category
* id
* name    彩种名字
* title   彩种标识
#####表名
* gamelist -> game_list
* lotteryrecord -> bet_record
* lotteryhistory -> open_history

##### 新增数据库字段：
* game_list.interval  开奖间隔
* game_list.url       路由地址
* game_list.icon      图标
* game_list.note      简介
* game_list.start_at  开盘时间
* game_list.end_at    休盘时间
* game_list.maintain  是否维护 1正常 0 维护

* wafan.grandpa           归属彩种
* wanfa.parent_game_id    所属游戏ID
* wanfa.parent_game_name  所属游戏名字
* wanfa.category          玩法分类
* wanfa.category_title    玩法分类标识

bet_record.wanfa_id     玩法id
##### 移除数据表:
* game_wanfa

---
#10.27
##### 新增数据库字段
* game_list.api_url             开奖API接口地址
* game_list.api_status          是否开启
* game_list.frequency           频率
