// Java�ɂ��Applet�쐬�Ɛ}�`�`��̊�{
import java.applet.* ; // ���܂��Ȃ�
import java.awt.* ;    // ���܂��Ȃ�

// sample01�̓v���O������(���m�ɂ̓N���X��)��,
// �v���O���}���C�ӂɐݒ肷��(�������t�@�C�����ƈ�v�����Ă���)
public class sample01 extends Applet {

  // ��ʂɕ`�施�߂� paint ���\�b�h���ɒ�`����
  public void paint (Graphics g) {
    // �`��F�Ɣw�i�F�̐ݒ�
    setForeground(Color.black) ;
    setBackground(Color.green) ;

    // ���W���_�ɖ���`���C���W�l��\��
    g.drawLine( 0,0, 50, 50 ) ;
    g.drawLine( 0,0,  3, 10 ) ;
    g.drawLine( 0,0, 10,  3 ) ;
    g.drawString("(0,0)",50,50) ;

    // ��{�}�`��\��
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

    // �E���ɖ���`���C���W�l��\��
    g.drawLine( 519, 449, 519-50, 449-50 ) ;
    g.drawLine( 519, 449, 519 -3, 449-10 ) ;
    g.drawLine( 519, 449, 519-10, 449 -3 ) ;
    g.drawString("(519,449)",519-50,449-50) ;
  }
}

