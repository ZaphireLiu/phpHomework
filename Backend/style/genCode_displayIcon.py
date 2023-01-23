# 输出代码，显示css文件中的图标以供选择
import re

# 目前找到可能包含图标的就这仨文件
fileList = ['font-awesome.css', 'typicons.css', 'weather-icons.css']

# .wi-day-cloudy-gusts:before {
p = re.compile(r' {0,}\.(.*?):before {')
for fileName in fileList:
    print(fileName)
    file = open(fileName, 'r', encoding='UTF-8')
    outputFile = open('iconGen_{}.txt'.format(fileName.split('.css')[0]), 'w', encoding='UTF-8')
    iconNameList = []
    for s in file.readlines():
        res = p.search(s)
        if res:
            outputFile.write('\t'*2 + '<tr><td><i class="{1} {0}"></i></td><td>{1} {0}</td></tr>\n'.format(res.groups()[0], res.groups()[0].split('-')[0]))
    outputFile.close()
    file.close()

input()