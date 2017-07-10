# 前言 
- [x] xpdf可将pdf内容解析为php可读的文本内容
- [x] antiword可将doc(注意不是docx)内容解析为php可读的文本内容
****
# 一.xpdf安装指南

参考链接：http://www.cnblogs.com/yinhutaxue/p/Yihoo.html

### 1.1 前往官网:http://www.foolabs.com/xpdf<br/>
        (1)xpdfbin-linux-3.04.tar.gz
        (2)xpdfbin-linux-3.04.tar.gz
***
### 1.2 inux操作
      cd /usr/local
      tar zxvf xpdfbin-linux-3.04.tar.gz -C /usr/local
      cd /usr/local/xpdfbin-linux-3.04  
      cat INSTALL
      cd bin32/
      cp ./* /usr/local/bin/
      cd ../doc/
      mkdir -p /usr/local/man/man1
      mkdir -p /usr/local/man/man5
      cp *.1 /usr/local/man/man1
      cp *.5 /usr/local/man/man5
#### 下面是中文语言包支持安装
      cp sample-xpdfrc /usr/local/etc/xpdfrc
      tar zxvf xpdf-chinese-simplified.tar.gz -C /usr/local
      cd /usr/local/xpdf-chinese-simplified
      mkdir -p /usr/local/share/xpdf/chinese-simplified
      cp -r Adobe-GB1.cidToUnicode ISO-2022-CN.unicodeMap EUC-CN.unicodeMap GBK.unicodeMap CMap /usr/local/share/xpdf/chinese-simplified/
      shell端命令调用（W020151204630497494614.pdf文件已经下载到shell命令当前目录中）：
      pdftotext W020151204630497494614.pdf     //没有采用字体库，存在乱码
      pdftotext -layout -enc GBK W020151204630497494614.pdf    //无乱码
#### pdftotext注意事项
- [x] xpdf的配置文件如果出现乱码的现象必须要去掉`textEncoding=utf-8`的选项
- [x] php.ini中的disable_function 中剔除shell_exec
- [x] 注意pdftotext的执行权限 确保对apache或者nginx有执行权限和写权限
- [x] php调用示例 `shell_exec('/usr/local/bin/pdftotext filename')`
- [x] 调用该命令行之后会自动生成同名的以txt为后缀的文件
- [x] `pdftotext -layout -enc GBK W020151204630497494614.pdf` //如果上例无法调用 则可以考虑使用此行代码
#### php调用示例：
```PHP
   shell_exec('/usr/local/bin/pdftotext filename')    
```
****
# 二 antiword安装
### 2.1 前往官网:http://www.winfield.demon.nl/linux/antiword-0.37.tar.gz
下载完，解压，进入目录
使用命令 `make && make install`
安装时，自动安装到了/root/目录下，只有root才可执行该命令，我们需要改一下路径，COPY到/usr中方便调用。
```
cp /root/bin/*antiword /usr/local/bin/
mkdir /usr/share/antiword
cp -R /root/.antiword/* /usr/share/antiword/
chmod 777 /usr/local/bin/*antiword
chmod 755 /usr/share/antiword/*
```
- [x] 确保shell_exec不再php.ini中的disable_function中
- [x] php端执行 `$content = shell_exec('/usr/local/bin/antiword -m UTF-8.txt '.$filename);`
- [x] 确保/usr/local/bin/antiword 对apache或者nginx用户有执行和写权限






