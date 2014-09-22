import java.awt.Graphics;
import java.awt.Image;
import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.util.StringTokenizer;
import java.util.Vector;

import javax.swing.ImageIcon;

/*
 * Created on 2006/5/5
 *
 */

/**
 * @author mori
 * 
 */
public class Map implements Common {
    // �}�b�v
    private int[][] map;

    // �}�b�v�̍s���E�񐔁i�P�ʁF�}�X�j
    private int row;
    private int col;

    // �}�b�v�S�̂̑傫���i�P�ʁF�s�N�Z���j
    private int width;
    private int height;

    private static Image chipImage;

    // ���̃}�b�v�ɂ���L�����N�^�[����
    private Vector charas = new Vector();
    // ���̃}�b�v�ɂ���C�x���g
    private Vector events = new Vector();

    // ���C���p�l���ւ̎Q��
    private MainPanel panel;

    // �}�b�v�t�@�C����
    private String mapFile;

    // BGM�ԍ�
    private int bgmNo;

    /**
     * �R���X�g���N�^
     * 
     * @param mapFile �}�b�v�t�@�C����
     * @param eventFile �C�x���g�t�@�C����
     * @param bgmNo BGM�ԍ�
     * @param panel �p�l���ւ̎Q��
     */
    public Map(String mapFile, String eventFile, int bgmNo, MainPanel panel) {
        this.mapFile = mapFile;
        this.bgmNo = bgmNo;

        // �}�b�v�����[�h
        load(mapFile);

        // �C�x���g�����[�h
        loadEvent(eventFile);

        // ����̌Ăяo���̂݃C���[�W�����[�h
        if (chipImage == null) {
            loadImage();
        }
    }

    public void draw(Graphics g, int offsetX, int offsetY) {
        // �I�t�Z�b�g�����ɕ`��͈͂����߂�
        int firstTileX = pixelsToTiles(-offsetX);
        int lastTileX = firstTileX + pixelsToTiles(MainPanel.WIDTH) + 1;
        // �`��͈͂��}�b�v�̑傫�����傫���Ȃ�Ȃ��悤�ɒ���
        lastTileX = Math.min(lastTileX, col);

        int firstTileY = pixelsToTiles(-offsetY);
        int lastTileY = firstTileY + pixelsToTiles(MainPanel.HEIGHT) + 1;
        // �`��͈͂��}�b�v�̑傫�����傫���Ȃ�Ȃ��悤�ɒ���
        lastTileY = Math.min(lastTileY, row);

        for (int i = firstTileY; i < lastTileY; i++) {
            for (int j = firstTileX; j < lastTileX; j++) {
                int mapChipNo = map[i][j];
                // �C���[�W��̈ʒu�����߂�
                // �}�b�v�`�b�v�C���[�W��8x8��z��
                int cx = (mapChipNo % 8) * CS;
                int cy = (mapChipNo / 8) * CS;
                g.drawImage(chipImage, tilesToPixels(j) + offsetX,
                        tilesToPixels(i) + offsetY, tilesToPixels(j) + offsetX
                                + CS, tilesToPixels(i) + offsetY + CS, cx, cy,
                        cx + CS, cy + CS, panel);

                // (j, i) �ɂ���C�x���g��`��
                for (int n = 0; n < events.size(); n++) {
                    Event event = (Event) events.get(n);
                    // �C�x���g��(j, i)�ɂ���Ε`��
                    if (event.x == j && event.y == i) {
                        mapChipNo = event.chipNo;
                        cx = (mapChipNo % 8) * CS;
                        cy = (mapChipNo / 8) * CS;
                        g.drawImage(chipImage, tilesToPixels(j) + offsetX,
                                tilesToPixels(i) + offsetY, tilesToPixels(j)
                                        + offsetX + CS, tilesToPixels(i)
                                        + offsetY + CS, cx, cy, cx + CS, cy
                                        + CS, panel);
                    }
                }
            }
        }

        // ���̃}�b�v�ɂ���L�����N�^�[��`��
        for (int n = 0; n < charas.size(); n++) {
            Chara chara = (Chara) charas.get(n);
            chara.draw(g, offsetX, offsetY);
        }
    }

    /**
     * (x,y)�ɂԂ�����̂����邩���ׂ�B
     * 
     * @param x �}�b�v��x���W
     * @param y �}�b�v��y���W
     * @return (x,y)�ɂԂ�����̂���������true��Ԃ��B
     */
    public boolean isHit(int x, int y) {
        // (x,y)�ɕǂ��ʍ����C���J�E���^�[����������Ԃ���
        if (map[y][x] == 1 || map[y][x] == 2 || map[y][x] == 5
                || map[y][x] == 19) {
            return true;
        }

        // ���̃L�����N�^�[�����邩
        for (int i = 0; i < charas.size(); i++) {
            Chara chara = (Chara) charas.get(i);
            if (chara.getX() == x && chara.getY() == y) {
                return true;
            }
        }

        // �Ԃ���C�x���g�����邩
        for (int i = 0; i < events.size(); i++) {
            Event event = (Event) events.get(i);
            if (event.x == x && event.y == y) {
                return event.isHit;
            }
        }

        // �Ȃ���΂Ԃ���Ȃ�
        return false;
    }

    /**
     * �L�����N�^�[�����̃}�b�v�ɒǉ�����
     * 
     * @param chara �L�����N�^�[
     */
    public void addChara(Chara chara) {
        charas.add(chara);
    }

    /**
     * �L�����N�^�[�����̃}�b�v����폜����
     * 
     * @param chara �L�����N�^�[
     */
    public void removeChara(Chara chara) {
        charas.remove(chara);
    }

    /**
     * (x,y)�ɃL�����N�^�[�����邩���ׂ�
     * 
     * @param x X���W
     * @param y Y���W
     * @return (x,y)�ɂ���L�����N�^�[�A���Ȃ�������null
     */
    public Chara charaCheck(int x, int y) {
        for (int i = 0; i < charas.size(); i++) {
            Chara chara = (Chara) charas.get(i);
            if (chara.getX() == x && chara.getY() == y) {
                return chara;
            }
        }

        return null;
    }

    /**
     * (x,y)�ɃC�x���g�����邩���ׂ�
     * 
     * @param x X���W
     * @param y Y���W
     * @return (x,y)�ɂ���C�x���g�A���Ȃ�������null
     */
    public Event eventCheck(int x, int y) {
        for (int i = 0; i < events.size(); i++) {
            Event event = (Event) events.get(i);
            if (event.x == x && event.y == y) {
                return event;
            }
        }

        return null;
    }

    /**
     * �o�^����Ă���C�x���g���폜����
     * 
     * @param event �폜�������C�x���g
     */
    public void removeEvent(Event event) {
        events.remove(event);
    }

    /**
     * �s�N�Z���P�ʂ��}�X�P�ʂɕύX����
     * 
     * @param pixels �s�N�Z���P��
     * @return �}�X�P��
     */
    public static int pixelsToTiles(double pixels) {
        return (int) Math.floor(pixels / CS);
    }

    /**
     * �}�X�P�ʂ��s�N�Z���P�ʂɕύX����
     * 
     * @param tiles �}�X�P��
     * @return �s�N�Z���P��
     */
    public static int tilesToPixels(int tiles) {
        return tiles * CS;
    }

    public int getRow() {
        return row;
    }

    public int getCol() {
        return col;
    }

    public int getWidth() {
        return width;
    }

    public int getHeight() {
        return height;
    }

    public Vector getCharas() {
        return charas;
    }

    /**
     * �t�@�C������}�b�v��ǂݍ���
     * 
     * @param filename �ǂݍ��ރ}�b�v�f�[�^�̃t�@�C����
     */
    private void load(String filename) {
        try {
            BufferedReader br = new BufferedReader(new InputStreamReader(
                    getClass().getResourceAsStream(filename)));
            // row��ǂݍ���
            String line = br.readLine();
            row = Integer.parseInt(line);
            // col��ǂ�
            line = br.readLine();
            col = Integer.parseInt(line);
            // �}�b�v�T�C�Y��ݒ�
            width = col * CS;
            height = row * CS;
            // �}�b�v���쐬
            map = new int[row][col];
            for (int i = 0; i < row; i++) {
                line = br.readLine();
                for (int j = 0; j < col; j++) {
                    map[i][j] = Integer.parseInt(line.charAt(j) + "");
                }
            }
            // show();
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    /**
     * �C�x���g�����[�h����
     * 
     * @param filename �C�x���g�t�@�C��
     */
    private void loadEvent(String filename) {
        try {
            BufferedReader br = new BufferedReader(new InputStreamReader(
                    getClass().getResourceAsStream(filename), "Shift_JIS"));
            String line;
            while ((line = br.readLine()) != null) {
                // ��s�͓ǂݔ�΂�
                if (line.equals(""))
                    continue;
                // �R�����g�s�͓ǂݔ�΂�
                if (line.startsWith("#"))
                    continue;
                StringTokenizer st = new StringTokenizer(line, ",");
                // �C�x���g�����擾����
                // �C�x���g�^�C�v���擾���ăC�x���g���Ƃɏ�������
                String eventType = st.nextToken();
                if (eventType.equals("CHARA")) { // �L�����N�^�[�C�x���g
                    makeCharacter(st);
                } else if (eventType.equals("TREASURE")) { // �󔠃C�x���g
                    makeTreasure(st);
                } else if (eventType.equals("DOOR")) { // �h�A�C�x���g
                    makeDoor(st);
                } else if (eventType.equals("MOVE")) { // �ړ��C�x���g
                    makeMove(st);
                }
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    private void loadImage() {
        // �}�b�v�`�b�v�̃C���[�W�����[�h
        ImageIcon icon = new ImageIcon(getClass().getResource(
                "image/mapchip.gif"));
        chipImage = icon.getImage();
    }

    /**
     * �L�����N�^�[�C�x���g���쐬
     */
    private void makeCharacter(StringTokenizer st) {
        // �C�x���g�̍��W
        int x = Integer.parseInt(st.nextToken());
        int y = Integer.parseInt(st.nextToken());
        // �L�����N�^�ԍ�
        int charaNo = Integer.parseInt(st.nextToken());
        // ����
        int dir = Integer.parseInt(st.nextToken());
        // �ړ��^�C�v
        int moveType = Integer.parseInt(st.nextToken());
        // ���b�Z�[�W
        String message = st.nextToken();
        // �L�����N�^�[���쐬
        Chara c = new Chara(x, y, charaNo, dir, moveType, this);
        // ���b�Z�[�W��o�^
        c.setMessage(message);
        // �L�����N�^�[�x�N�g���ɓo�^
        charas.add(c);
    }

    /**
     * �󔠃C�x���g���쐬
     */
    private void makeTreasure(StringTokenizer st) {
        // �󔠂̍��W
        int x = Integer.parseInt(st.nextToken());
        int y = Integer.parseInt(st.nextToken());
        // �A�C�e����
        String itemName = st.nextToken();
        // �󔠃C�x���g���쐬
        TreasureEvent t = new TreasureEvent(x, y, itemName);
        // �󔠃C�x���g��o�^
        events.add(t);
    }

    /**
     * �Ƃт�C�x���g���쐬
     */
    private void makeDoor(StringTokenizer st) {
        // �Ƃт�̍��W
        int x = Integer.parseInt(st.nextToken());
        int y = Integer.parseInt(st.nextToken());
        // �Ƃт�C�x���g���쐬
        DoorEvent d = new DoorEvent(x, y);
        // �Ƃт�C�x���g��o�^
        events.add(d);
    }

    /**
     * �ړ��C�x���g���쐬
     */
    private void makeMove(StringTokenizer st) {
        // �ړ��C�x���g�̍��W
        int x = Integer.parseInt(st.nextToken());
        int y = Integer.parseInt(st.nextToken());
        // �`�b�v�ԍ�
        int chipNo = Integer.parseInt(st.nextToken());
        // �ړ���̃}�b�v�ԍ�
        int destMapNo = Integer.parseInt(st.nextToken());
        // �ړ����X���W
        int destX = Integer.parseInt(st.nextToken());
        // �ړ����Y���W
        int destY = Integer.parseInt(st.nextToken());
        // �ړ��C�x���g���쐬
        MoveEvent m = new MoveEvent(x, y, chipNo, destMapNo, destX, destY);
        // �ړ��C�x���g��o�^
        events.add(m);
    }

    /**
     * �}�b�v���R���\�[���ɕ\���B�f�o�b�O�p�B
     */
    public void show() {
        for (int i = 0; i < row; i++) {
            for (int j = 0; j < col; j++) {
                System.out.print(map[i][j]);
            }
            System.out.println();
        }
    }

    /**
     * ���̃}�b�v��BGM�ԍ���Ԃ�
     * 
     * @return BGM�ԍ�
     */
    public int getBgmNo() {
        return bgmNo;
    }

    public String getMapName() {
        return mapFile;
    }
}
