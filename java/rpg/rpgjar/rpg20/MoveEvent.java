/*
 * Created on 2005/12/03
 *
 */

/**
 * @author mori
 *
 */
public class MoveEvent extends Event {
    // �ړ���̃}�b�v�ԍ�
    public int destMapNo;
    // �ړ����X���W
    public int destX;
    // �ړ����Y���W
    public int destY;
    
    public MoveEvent(int x, int y, int chipNo, int destMapNo, int destX, int destY) {
        // ��ɏ��ƈړ�����悤�ɂ������̂łԂ���Ȃ��ifalse�j�ɐݒ�
        super(x, y, chipNo, false);
        this.destMapNo = destMapNo;
        this.destX = destX;
        this.destY = destY;
    }
    
    public String toString() {
        return "MOVE:" + super.toString() + ":" + destMapNo + ":" + destX + ":" + destY;
    }
}
