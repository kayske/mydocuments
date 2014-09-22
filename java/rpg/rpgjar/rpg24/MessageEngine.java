import java.awt.Graphics;
import java.awt.Image;
import java.awt.Point;
import java.util.HashMap;

import javax.swing.ImageIcon;

/*
 * Created on 2005/09/23
 *
 */

/**
 * @author mori
 *
 */
public class MessageEngine {
    // �t�H���g�̑傫��
    public static final int FONT_WIDTH = 16;
    public static final int FONT_HEIGHT = 22;
    
    // �t�H���g�̐F
    public static final int WHITE = 0;
    public static final int RED = 160;
    public static final int GREEN = 320;
    public static final int BLUE = 480;
    
    // �t�H���g�C���[�W
    private Image fontImage;
    // ���ȁ����W�̃n�b�V��
    private HashMap kana2Pos;
    
    // �F
    private int color;

    public MessageEngine() {
        // �t�H���g�C���[�W�����[�h
        ImageIcon icon = new ImageIcon(getClass().getResource("image/font.gif"));
        fontImage = icon.getImage();
        
        color = WHITE;
        
        // ���ȁ��C���[�W���W�ւ̃n�b�V�����쐬
        kana2Pos = new HashMap();
        createHash();
    }
    
    public void setColor(int c) {     
        this.color = c;
        
        // �ςȒl��������WHITE�ɂ���
        if (color != WHITE && color != RED && color != GREEN && color != BLUE) {
            this.color = WHITE;
        }
    }
    
    /**
     * ���b�Z�[�W��`�悷��
     * @param x X���W
     * @param y Y���W
     * @param message ���b�Z�[�W
     * @param g �`��I�u�W�F�N�g
     */
    public void drawMessage(int x, int y, String message, Graphics g) {
        for (int i=0; i<message.length(); i++) {
            char c = message.charAt(i);
            int dx = x + FONT_WIDTH * i;
            drawCharacter(dx, y, c, g);
        }
    }
    
    /**
     * ������`�悷��
     * @param x X���W
     * @param y Y���W
     * @param c ����
     * @param g �`��I�u�W�F�N�g
     */
    public void drawCharacter(int x, int y, char c, Graphics g) {
        Point pos = (Point)kana2Pos.get(new Character(c));
        g.drawImage(fontImage, x, y, x + FONT_WIDTH, y + FONT_HEIGHT,
                pos.x + color, pos.y, pos.x + color + FONT_WIDTH, pos.y + FONT_HEIGHT, null);
    }
    
    /**
     * ����������W�ւ̃n�b�V�����쐬����
     */
    private void createHash() {
        kana2Pos.put(new Character('��'), new Point(0, 0));
        kana2Pos.put(new Character('��'), new Point(16, 0));
        kana2Pos.put(new Character('��'), new Point(32, 0));
        kana2Pos.put(new Character('��'), new Point(48, 0));
        kana2Pos.put(new Character('��'), new Point(64, 0));
        
        kana2Pos.put(new Character('��'), new Point(0, 22));
        kana2Pos.put(new Character('��'), new Point(16, 22));
        kana2Pos.put(new Character('��'), new Point(32, 22));
        kana2Pos.put(new Character('��'), new Point(48, 22));
        kana2Pos.put(new Character('��'), new Point(64, 22));
        
        kana2Pos.put(new Character('��'), new Point(0, 44));
        kana2Pos.put(new Character('��'), new Point(16, 44));
        kana2Pos.put(new Character('��'), new Point(32, 44));
        kana2Pos.put(new Character('��'), new Point(48, 44));
        kana2Pos.put(new Character('��'), new Point(64, 44));
        
        kana2Pos.put(new Character('��'), new Point(0, 66));
        kana2Pos.put(new Character('��'), new Point(16, 66));
        kana2Pos.put(new Character('��'), new Point(32, 66));
        kana2Pos.put(new Character('��'), new Point(48, 66));
        kana2Pos.put(new Character('��'), new Point(64, 66));
        
        kana2Pos.put(new Character('��'), new Point(0, 88));
        kana2Pos.put(new Character('��'), new Point(16, 88));
        kana2Pos.put(new Character('��'), new Point(32, 88));
        kana2Pos.put(new Character('��'), new Point(48, 88));
        kana2Pos.put(new Character('��'), new Point(64, 88));
        
        kana2Pos.put(new Character('��'), new Point(0, 110));
        kana2Pos.put(new Character('��'), new Point(16, 110));
        kana2Pos.put(new Character('��'), new Point(32, 110));
        kana2Pos.put(new Character('��'), new Point(48, 110));
        kana2Pos.put(new Character('��'), new Point(64, 110));
        
        kana2Pos.put(new Character('��'), new Point(0, 132));
        kana2Pos.put(new Character('��'), new Point(16, 132));
        kana2Pos.put(new Character('��'), new Point(32, 132));
        kana2Pos.put(new Character('��'), new Point(48, 132));
        kana2Pos.put(new Character('��'), new Point(64, 132));
        
        kana2Pos.put(new Character('��'), new Point(0, 154));
        kana2Pos.put(new Character('��'), new Point(16, 154));
        kana2Pos.put(new Character('��'), new Point(32, 154));
        kana2Pos.put(new Character('��'), new Point(48, 154));
        kana2Pos.put(new Character('��'), new Point(64, 154));
        
        kana2Pos.put(new Character('��'), new Point(0, 176));
        kana2Pos.put(new Character('��'), new Point(16, 176));
        kana2Pos.put(new Character('��'), new Point(32, 176));
        kana2Pos.put(new Character('��'), new Point(48, 176));
        kana2Pos.put(new Character('��'), new Point(64, 176));
        
        kana2Pos.put(new Character('��'), new Point(0, 198));
        kana2Pos.put(new Character('��'), new Point(16, 198));
        kana2Pos.put(new Character('��'), new Point(32, 198));
        kana2Pos.put(new Character('��'), new Point(48, 198));
        kana2Pos.put(new Character('�@'), new Point(64, 198));
        
        kana2Pos.put(new Character('��'), new Point(0, 220));
        kana2Pos.put(new Character('��'), new Point(16, 220));
        kana2Pos.put(new Character('��'), new Point(32, 220));
        kana2Pos.put(new Character('�A'), new Point(48, 220));
        kana2Pos.put(new Character('�B'), new Point(64, 220));
        
        kana2Pos.put(new Character('��'), new Point(0, 242));
        kana2Pos.put(new Character('��'), new Point(16, 242));
        kana2Pos.put(new Character('��'), new Point(32, 242));
        kana2Pos.put(new Character('��'), new Point(48, 242));
        kana2Pos.put(new Character('��'), new Point(64, 242));
        
        kana2Pos.put(new Character('��'), new Point(0, 264));
        kana2Pos.put(new Character('��'), new Point(16, 264));
        kana2Pos.put(new Character('��'), new Point(32, 264));
        kana2Pos.put(new Character('��'), new Point(48, 264));
        kana2Pos.put(new Character('��'), new Point(64, 264));
        
        kana2Pos.put(new Character('��'), new Point(0, 286));
        kana2Pos.put(new Character('��'), new Point(16, 286));
        kana2Pos.put(new Character('��'), new Point(32, 286));
        kana2Pos.put(new Character('��'), new Point(48, 286));
        kana2Pos.put(new Character('��'), new Point(64, 286));
        
        kana2Pos.put(new Character('��'), new Point(0, 308));
        kana2Pos.put(new Character('��'), new Point(16, 308));
        kana2Pos.put(new Character('��'), new Point(32, 308));
        kana2Pos.put(new Character('��'), new Point(48, 308));
        kana2Pos.put(new Character('��'), new Point(64, 308));
        
        kana2Pos.put(new Character('��'), new Point(0, 330));
        kana2Pos.put(new Character('��'), new Point(16, 330));
        kana2Pos.put(new Character('��'), new Point(32, 330));
        kana2Pos.put(new Character('��'), new Point(48, 330));
        kana2Pos.put(new Character('��'), new Point(64, 330));
        
        kana2Pos.put(new Character('�A'), new Point(80, 0));
        kana2Pos.put(new Character('�C'), new Point(96, 0));
        kana2Pos.put(new Character('�E'), new Point(112, 0));
        kana2Pos.put(new Character('�G'), new Point(128, 0));
        kana2Pos.put(new Character('�I'), new Point(144, 0));
        
        kana2Pos.put(new Character('�J'), new Point(80, 22));
        kana2Pos.put(new Character('�L'), new Point(96, 22));
        kana2Pos.put(new Character('�N'), new Point(112, 22));
        kana2Pos.put(new Character('�P'), new Point(128, 22));
        kana2Pos.put(new Character('�R'), new Point(144, 22));

        kana2Pos.put(new Character('�T'), new Point(80, 44));
        kana2Pos.put(new Character('�V'), new Point(96, 44));
        kana2Pos.put(new Character('�X'), new Point(112, 44));
        kana2Pos.put(new Character('�Z'), new Point(128, 44));
        kana2Pos.put(new Character('�\'), new Point(144, 44));
        
        kana2Pos.put(new Character('�^'), new Point(80, 66));
        kana2Pos.put(new Character('�`'), new Point(96, 66));
        kana2Pos.put(new Character('�c'), new Point(112, 66));
        kana2Pos.put(new Character('�e'), new Point(128, 66));
        kana2Pos.put(new Character('�g'), new Point(144, 66));
        
        kana2Pos.put(new Character('�i'), new Point(80, 88));
        kana2Pos.put(new Character('�j'), new Point(96, 88));
        kana2Pos.put(new Character('�k'), new Point(112, 88));
        kana2Pos.put(new Character('�l'), new Point(128, 88));
        kana2Pos.put(new Character('�m'), new Point(144, 88));
        
        kana2Pos.put(new Character('�n'), new Point(80, 110));
        kana2Pos.put(new Character('�q'), new Point(96, 110));
        kana2Pos.put(new Character('�t'), new Point(112, 110));
        kana2Pos.put(new Character('�w'), new Point(128, 110));
        kana2Pos.put(new Character('�z'), new Point(144, 110));
        
        kana2Pos.put(new Character('�}'), new Point(80, 132));
        kana2Pos.put(new Character('�~'), new Point(96, 132));
        kana2Pos.put(new Character('��'), new Point(112, 132));
        kana2Pos.put(new Character('��'), new Point(128, 132));
        kana2Pos.put(new Character('��'), new Point(144, 132));
        
        kana2Pos.put(new Character('��'), new Point(80, 154));
        kana2Pos.put(new Character('��'), new Point(96, 154));
        kana2Pos.put(new Character('��'), new Point(112, 154));
        kana2Pos.put(new Character('��'), new Point(128, 154));
        kana2Pos.put(new Character('��'), new Point(144, 154));
        
        kana2Pos.put(new Character('��'), new Point(80, 176));
        kana2Pos.put(new Character('��'), new Point(96, 176));
        kana2Pos.put(new Character('��'), new Point(112, 176));
        kana2Pos.put(new Character('��'), new Point(128, 176));
        kana2Pos.put(new Character('��'), new Point(144, 176));
        
        kana2Pos.put(new Character('��'), new Point(80, 198));
        kana2Pos.put(new Character('�B'), new Point(96, 198));
        kana2Pos.put(new Character('�b'), new Point(112, 198));
        kana2Pos.put(new Character('�F'), new Point(128, 198));
        kana2Pos.put(new Character('�u'), new Point(144, 198));
        
        kana2Pos.put(new Character('��'), new Point(80, 220));
        kana2Pos.put(new Character('��'), new Point(96, 220));
        kana2Pos.put(new Character('��'), new Point(112, 220));
        kana2Pos.put(new Character('�['), new Point(128, 220));
        kana2Pos.put(new Character('�v'), new Point(144, 220));
        
        kana2Pos.put(new Character('�K'), new Point(80, 242));
        kana2Pos.put(new Character('�M'), new Point(96, 242));
        kana2Pos.put(new Character('�O'), new Point(112, 242));
        kana2Pos.put(new Character('�Q'), new Point(128, 242));
        kana2Pos.put(new Character('�S'), new Point(144, 242));
        
        kana2Pos.put(new Character('�U'), new Point(80, 264));
        kana2Pos.put(new Character('�W'), new Point(96, 264));
        kana2Pos.put(new Character('�Y'), new Point(112, 264));
        kana2Pos.put(new Character('�['), new Point(128, 264));
        kana2Pos.put(new Character('�]'), new Point(144, 264));
        
        kana2Pos.put(new Character('�_'), new Point(80, 286));
        kana2Pos.put(new Character('�a'), new Point(96, 286));
        kana2Pos.put(new Character('�d'), new Point(112, 286));
        kana2Pos.put(new Character('�f'), new Point(128, 286));
        kana2Pos.put(new Character('�h'), new Point(144, 286));
        
        kana2Pos.put(new Character('�o'), new Point(80, 308));
        kana2Pos.put(new Character('�r'), new Point(96, 308));
        kana2Pos.put(new Character('�u'), new Point(112, 308));
        kana2Pos.put(new Character('�x'), new Point(128, 308));
        kana2Pos.put(new Character('�{'), new Point(144, 308));
        
        kana2Pos.put(new Character('�p'), new Point(80, 330));
        kana2Pos.put(new Character('�s'), new Point(96, 330));
        kana2Pos.put(new Character('�v'), new Point(112, 330));
        kana2Pos.put(new Character('�y'), new Point(128, 330));
        kana2Pos.put(new Character('�|'), new Point(144, 330));
        
        kana2Pos.put(new Character('0'), new Point(0, 352));        
        kana2Pos.put(new Character('1'), new Point(16, 352));
        kana2Pos.put(new Character('2'), new Point(32, 352));
        kana2Pos.put(new Character('3'), new Point(48, 352));
        kana2Pos.put(new Character('4'), new Point(64, 352));
        kana2Pos.put(new Character('5'), new Point(80, 352));
        kana2Pos.put(new Character('6'), new Point(96, 352));
        kana2Pos.put(new Character('7'), new Point(112, 352));
        kana2Pos.put(new Character('8'), new Point(128, 352));
        kana2Pos.put(new Character('9'), new Point(144, 352));
        
        kana2Pos.put(new Character('�`'), new Point(0, 374));        
        kana2Pos.put(new Character('�a'), new Point(16, 374));
        kana2Pos.put(new Character('�b'), new Point(32, 374));
        kana2Pos.put(new Character('�c'), new Point(48, 374));
        kana2Pos.put(new Character('�d'), new Point(64, 374));
        kana2Pos.put(new Character('�e'), new Point(80, 374));
        kana2Pos.put(new Character('�f'), new Point(96, 374));
        kana2Pos.put(new Character('�g'), new Point(112, 374));
        kana2Pos.put(new Character('�h'), new Point(128, 374));
        kana2Pos.put(new Character('�i'), new Point(144, 374));
        
        kana2Pos.put(new Character('�j'), new Point(0, 396));        
        kana2Pos.put(new Character('�k'), new Point(16, 396));
        kana2Pos.put(new Character('�l'), new Point(32, 396));
        kana2Pos.put(new Character('�m'), new Point(48, 396));
        kana2Pos.put(new Character('�n'), new Point(64, 396));
        kana2Pos.put(new Character('�o'), new Point(80, 396));
        kana2Pos.put(new Character('�p'), new Point(96, 396));
        kana2Pos.put(new Character('�q'), new Point(112, 396));
        kana2Pos.put(new Character('�r'), new Point(128, 396));
        kana2Pos.put(new Character('�s'), new Point(144, 396));
        
        kana2Pos.put(new Character('�t'), new Point(0, 418));        
        kana2Pos.put(new Character('�u'), new Point(16, 418));
        kana2Pos.put(new Character('�v'), new Point(32, 418));
        kana2Pos.put(new Character('�w'), new Point(48, 418));
        kana2Pos.put(new Character('�x'), new Point(64, 418));
        kana2Pos.put(new Character('�y'), new Point(80, 418));
        kana2Pos.put(new Character('�I'), new Point(96, 418));
        kana2Pos.put(new Character('�H'), new Point(112, 418));
    }
}
