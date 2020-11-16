#!/bin/bash

if [ -z $1 ];then
    str='太懒，未写备注！'
else
    str="$1"
fi

git add -A
git commit -m "$str"     # 赋值不用$符号，输出里要用$
git push

<<<<<<< HEAD
# envoy run wlpy           # 同步服务器
=======
envoy run hn666           # 同步服务器
>>>>>>> 3f65333f37ae81d6434eb1ed96b361c42c2e981b
