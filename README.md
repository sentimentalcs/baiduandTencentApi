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
     


