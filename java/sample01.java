// JavaによるApplet作成と図形描画の基本
import java.applet.* ; // おまじない
import java.awt.* ;    // おまじない

// sample01はプログラム名(正確にはクラス名)で,
// プログラマが任意に設定する(ただしファイル名と一致させておく)
public class sample01 extends Applet {

  // 一般に描画命令は paint メソッド内に定義する
  public void paint (Graphics g) {
    // 描画色と背景色の設定
    setForeground(Color.black) ;
    setBackground(Color.green) ;

    // 座標原点に矢印を描き，座標値を表示
    g.drawLine( 0,0, 50, 50 ) ;
    g.drawLine( 0,0,  3, 10 ) ;
    g.drawLine( 0,0, 10,  3 ) ;
    g.drawString("(0,0)",50,50) ;

    // 基本図形を表示
    g.drawString( "Rectangles", 50, 110 ) ;
    g.drawRect(  50, 120, 100, 100 ) ;
    g.fillRect(  50, 230, 100, 100 ) ;
    g.drawString( "Round-Rectangles", 210, 110 ) ;
    g.drawRoundRect(  210, 120, 100, 100, 20, 20 ) ;
    g.fillRoundRect(  210, 230, 100, 100, 20, 20 ) ;
    g.drawString( "Ovals", 370, 110 ) ;
    g.drawOval(  370, 120, 100, 100) ;
    g.fillOval(  370, 230, 100, 100) ;
    g.drawString("Line", 50, 350 ) ;
    g.drawLine( 50, 360, 470, 360 ) ;

    // 右下に矢印を描き，座標値を表示
    g.drawLine( 519, 449, 519-50, 449-50 ) ;
    g.drawLine( 519, 449, 519 -3, 449-10 ) ;
    g.drawLine( 519, 449, 519-10, 449 -3 ) ;
    g.drawString("(519,449)",519-50,449-50) ;
  }
}

